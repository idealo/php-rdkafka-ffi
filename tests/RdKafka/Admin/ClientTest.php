<?php

namespace RdKafka\Admin;

use Exception;
use PHPUnit\Framework\TestCase;
use RdKafka\Conf;
use RdKafka\Producer;

/**
 * @covers \RdKafka\Admin\Client
 * @covers \RdKafka\Admin\CreatePartitionsOptions
 * @covers \RdKafka\Admin\CreateTopicsOptions
 * @covers \RdKafka\Admin\ConfigEntry
 * @covers \RdKafka\Admin\ConfigResource
 * @covers \RdKafka\Admin\ConfigResourceResult
 * @covers \RdKafka\Admin\DeleteTopic
 * @covers \RdKafka\Admin\DeleteTopicsOptions
 * @covers \RdKafka\Admin\DescribeConfigsOptions
 * @covers \RdKafka\Admin\NewPartitions
 * @covers \RdKafka\Admin\NewTopic
 * @covers \RdKafka\Admin\Options
 * @covers \RdKafka\Admin\TopicResult
 *
 * @group ffiOnly
 */
class ClientTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->deleteTopics(
            [
                new DeleteTopic('test_admin_1'),
                new DeleteTopic('test_admin_2'),
                new DeleteTopic('test_admin_3'),
            ]
        );

        self::waitAfterTopicDeletion();
    }

    public function testCreateTopics()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $topics = [
            new NewTopic('test_admin_1', 1, 1),
            new NewTopic('test_admin_2', 2, 1),
        ];

        $options = $client->newCreateTopicsOptions();
        $options->setOperationTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->createTopics($topics, $options);

        $this->assertEquals('test_admin_1', $result[0]->name);
        $this->assertEquals('test_admin_2', $result[1]->name);

        $options->setValidateOnly(true);
        $result = $client->createTopics($topics, $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[0]->error);
        $this->assertEquals(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[1]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_1', 'test_admin_2']);

        $this->assertCount(2, $metaTopics);
        $this->assertCount(1, $metaTopics['test_admin_1']->getPartitions());
        $this->assertCount(2, $metaTopics['test_admin_2']->getPartitions());
    }

    /**
     * @depends testCreateTopics
     */
    public function testCreatePartitions()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $partitions = [
            new NewPartitions('test_admin_1', 4),
            new NewPartitions('test_admin_2', 6),
        ];

        $options = $client->newCreatePartitionsOptions();
        $options->setOperationTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->createPartitions($partitions, $options);

        $this->assertEquals('test_admin_1', $result[0]->name);
        $this->assertEquals('test_admin_2', $result[1]->name);

        $options->setValidateOnly(true);
        $result = $client->createPartitions($partitions, $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[0]->error);
        $this->assertEquals(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[1]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_1', 'test_admin_2']);

        $this->assertCount(2, $metaTopics);
        $this->assertCount(4, $metaTopics['test_admin_1']->getPartitions());
        $this->assertCount(6, $metaTopics['test_admin_2']->getPartitions());
    }

    /**
     * @depends testCreatePartitions
     */
    public function testDeleteTopics()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $topics = [
            new DeleteTopic('test_admin_1'),
            new DeleteTopic('test_admin_2'),
        ];

        $options = $client->newDeleteTopicsOptions();
        $options->setOperationTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->deleteTopics($topics, $options);

        $this->assertEquals('test_admin_1', $result[0]->name);
        $this->assertEquals('test_admin_2', $result[1]->name);

        $result = $client->deleteTopics($topics, $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART, $result[0]->error);
        $this->assertEquals(RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART, $result[1]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_1', 'test_admin_2']);

        $this->assertCount(0, $metaTopics);

        // wait after deletion
        self::waitAfterTopicDeletion();
    }

    /**
     * @depends testDeleteTopics
     */
    public function testCreateTopicsWithReplicaAssignment()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $topic = new NewTopic('test_admin_3', 2, -1);
        $topic->setReplicaAssignment(0, [(int)KAFKA_BROKER_ID]);
        $topic->setReplicaAssignment(1, [(int)KAFKA_BROKER_ID]);

        $options = $client->newCreateTopicsOptions();
        $options->setOperationTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->createTopics([$topic], $options);

        $this->assertEquals('test_admin_3', $result[0]->name);

        $options->setValidateOnly(true);
        $result = $client->createTopics([$topic], $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[0]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_3']);

        $this->assertNotNull($metaTopics['test_admin_3']);
        $this->assertCount(2, $metaTopics['test_admin_3']->getPartitions());
        foreach ($metaTopics['test_admin_3']->getPartitions() as $metaPartition) {
            $this->assertEquals((int)KAFKA_BROKER_ID, $metaPartition->getReplicas()->current());
        }
    }

    /**
     * @depends testCreateTopicsWithReplicaAssignment
     */
    public function testCreatePartitionsWithReplicaAssignment()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $partition = new NewPartitions('test_admin_3', 4);
        $partition->setReplicaAssignment(0, [(int)KAFKA_BROKER_ID]);
        $partition->setReplicaAssignment(1, [(int)KAFKA_BROKER_ID]);

        $options = $client->newCreatePartitionsOptions();
        $options->setOperationTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->createPartitions([$partition], $options);

        $this->assertEquals('test_admin_3', $result[0]->name);

        $options->setValidateOnly(true);
        $result = $client->createPartitions([$partition], $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[0]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_3']);

        $this->assertCount(1, $metaTopics);
        $this->assertCount(4, $metaTopics['test_admin_3']->getPartitions());
        foreach ($metaTopics['test_admin_3']->getPartitions() as $metaPartition) {
            $this->assertEquals((int)KAFKA_BROKER_ID, $metaPartition->getReplicas()->current());
        }
    }

    private function getFilteredMetaTopics(array $topicNames): array
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $metaTopics = [];
        $metadata = $producer->getMetadata(true, null, (int)KAFKA_TEST_TIMEOUT_MS);
        foreach ($metadata->getTopics() as $topic) {
            if (in_array($topic->getTopic(), $topicNames)) {
                $metaTopics[$topic->getTopic()] = $topic;
            }
        }
        return $metaTopics;
    }

    private static function waitAfterTopicDeletion()
    {
        usleep(500 * 1000);
    }

    public function testDescribeConfigs()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $configResource = new ConfigResource(RD_KAFKA_RESOURCE_BROKER, (string)KAFKA_BROKER_ID);

        $options = $client->newDescribeConfigsOptions();
        $options->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->describeConfigs([$configResource], $options);

        $configs = $this->getIndexedConfigEntries($result[0]->configs, ['broker.id', 'queued.max.requests']);

        $this->assertEquals('111', $result[0]->name);

        $this->assertEquals('111', $configs['broker.id']->value);
        $this->assertTrue($configs['broker.id']->isReadOnly);

        $this->assertEquals('500', $configs['queued.max.requests']->value);
        $this->assertTrue($configs['queued.max.requests']->isDefault);
    }

    public function testAlterConfigs()
    {
        // prepare
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('broker.version.fallback', '2.0.0');
        $client = Client::fromConf($conf);

        $configResource = new ConfigResource(RD_KAFKA_RESOURCE_BROKER, (string)KAFKA_BROKER_ID);
        $configResource->setConfig('max.connections.per.ip', (string)500000);

        $alterConfigOptions = $client->newAlterConfigsOptions();
        $alterConfigOptions->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $alterConfigOptions->setBrokerId((int)KAFKA_BROKER_ID);

        $describeConfigsOptions = $client->newDescribeConfigsOptions();
        $describeConfigsOptions->setRequestTimeout((int)KAFKA_TEST_TIMEOUT_MS);
        $describeConfigsOptions->setBrokerId((int)KAFKA_BROKER_ID);

        // alter config
        $result = $client->alterConfigs([$configResource], $alterConfigOptions);

        $this->assertEquals('111', $result[0]->name);

        // check chances
        usleep(50 * 1000);
        $result = $client->describeConfigs([$configResource], $describeConfigsOptions);

        $this->assertEquals('111', $result[0]->name);

        $configs = $this->getIndexedConfigEntries($result[0]->configs);

        $this->assertEquals('500000', $configs['max.connections.per.ip']->value);
        $this->assertFalse($configs['max.connections.per.ip']->isDefault);

        // set config back to old value (deleteConfig not supported yet....)
        $configResource->setConfig('max.connections.per.ip', '2147483647');
        $result = $client->alterConfigs([$configResource], $alterConfigOptions);

        $this->assertEquals('111', $result[0]->name);

        // check config changes
        usleep(50 * 1000);
        $result = $client->describeConfigs([$configResource], $describeConfigsOptions);

        $this->assertEquals('111', $result[0]->name);

        $configs = $this->getIndexedConfigEntries($result[0]->configs);

        $this->assertEquals('2147483647', $configs['max.connections.per.ip']->value);
    }

    /**
     * @param ConfigEntry[] $configs
     * @param string[] $configNames
     * @return ConfigEntry[]
     */
    private function getIndexedConfigEntries(array $configs): array
    {
        $filteredConfigs = [];
        foreach ($configs as $config) {
            if (isset($filteredConfigs[$config->name])) {
                throw new Exception('unexpected collision found');
            }
            $filteredConfigs[$config->name] = $config;
        }
        return $filteredConfigs;
    }
}
