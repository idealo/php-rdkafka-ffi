<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use Exception;
use PHPUnit\Framework\TestCase;
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use RdKafka\TopicPartition;

/**
 * @covers \RdKafka\Admin\AlterConfigsOptions
 * @covers \RdKafka\Admin\Client
 * @covers \RdKafka\Admin\ConfigEntry
 * @covers \RdKafka\Admin\ConfigResource
 * @covers \RdKafka\Admin\ConfigResourceResult
 * @covers \RdKafka\Admin\CreatePartitionsOptions
 * @covers \RdKafka\Admin\CreateTopicsOptions
 * @covers \RdKafka\Admin\DeleteRecords
 * @covers \RdKafka\Admin\DeleteRecordsOptions
 * @covers \RdKafka\Admin\DeleteTopic
 * @covers \RdKafka\Admin\DeleteTopicsOptions
 * @covers \RdKafka\Admin\DescribeConfigsOptions
 * @covers \RdKafka\Admin\NewPartitions
 * @covers \RdKafka\Admin\NewTopic
 * @covers \RdKafka\Admin\Options
 * @covers \RdKafka\Admin\TopicResult
 * @covers \RdKafka\Event
 *
 * @group ffiOnly
 * @requires OS Linux|Darwin
 *
 * Kafka crashes on Windows on deleting topics - see https://github.com/apache/kafka/pull/6329
 */
class ClientTest extends TestCase
{
    use \RequireVersionTrait;

    public static function setUpBeforeClass(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
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

    public function testCreateTopics(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $topics = [
            new NewTopic('test_admin_1', 1, 1),
            new NewTopic('test_admin_2', 2, 1),
        ];

        $options = $client->newCreateTopicsOptions();
        $options->setOperationTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->createTopics($topics, $options);

        $this->assertSame('test_admin_1', $result[0]->name);
        $this->assertSame('test_admin_2', $result[1]->name);

        $options->setValidateOnly(true);
        $result = $client->createTopics($topics, $options);

        $this->assertSame(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[0]->error);
        $this->assertSame(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[1]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_1', 'test_admin_2']);

        $this->assertCount(2, $metaTopics);
        $this->assertCount(1, $metaTopics['test_admin_1']->getPartitions());
        $this->assertCount(2, $metaTopics['test_admin_2']->getPartitions());
    }

    public function createTopicsWithEmptyTopicsParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/empty/');
        $this->expectExceptionMessageMatches('/topics/');
        $client->createTopics([]);
    }

    public function createTopicsWithInvalidElementsInTopicsParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches(NewTopic::class);
        $this->expectExceptionMessageMatches('/topics/');
        $client->createTopics([new \stdClass()]);
    }

    /**
     * @depends testCreateTopics
     */
    public function testCreatePartitions(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $partitions = [
            new NewPartitions('test_admin_1', 4),
            new NewPartitions('test_admin_2', 6),
        ];

        $options = $client->newCreatePartitionsOptions();
        $options->setOperationTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->createPartitions($partitions, $options);

        $this->assertSame('test_admin_1', $result[0]->name);
        $this->assertSame('test_admin_2', $result[1]->name);

        $options->setValidateOnly(true);
        $result = $client->createPartitions($partitions, $options);

        $this->assertSame(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[0]->error);
        $this->assertSame(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[1]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_1', 'test_admin_2']);

        $this->assertCount(2, $metaTopics);
        $this->assertCount(4, $metaTopics['test_admin_1']->getPartitions());
        $this->assertCount(6, $metaTopics['test_admin_2']->getPartitions());
    }

    public function testCreatePartitionsWithEmptyParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/empty/');
        $this->expectExceptionMessageMatches('/partitions/');
        $client->createPartitions([]);
    }

    public function testCreatePartitionsWithInvalidParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches(NewPartitions::class);
        $this->expectExceptionMessageMatches('/partitions/');
        $client->createPartitions([new \stdClass()]);
    }

    /**
     * @depends testCreatePartitions
     */
    public function testDeleteTopics(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $topics = [
            new DeleteTopic('test_admin_1'),
            new DeleteTopic('test_admin_2'),
        ];

        $options = $client->newDeleteTopicsOptions();
        $options->setOperationTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->deleteTopics($topics, $options);

        $this->assertSame('test_admin_1', $result[0]->name);
        $this->assertSame('test_admin_2', $result[1]->name);

        $result = $client->deleteTopics($topics, $options);

        $this->assertSame(RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART, $result[0]->error);
        $this->assertSame(RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART, $result[1]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_1', 'test_admin_2']);

        $this->assertCount(0, $metaTopics);

        // wait after deletion
        self::waitAfterTopicDeletion();
    }

    public function testDeleteTopicsWithEmptyParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/empty/');
        $this->expectExceptionMessageMatches('/topics/');
        $client->deleteTopics([]);
    }

    public function testDeleteTopicsWithInvalidParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches(DeleteTopic::class);
        $this->expectExceptionMessageMatches('/topics/');
        $client->deleteTopics([new \stdClass()]);
    }

    /**
     * @depends testDeleteTopics
     */
    public function testCreateTopicsWithReplicaAssignment(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $topic = new NewTopic('test_admin_3', 2, -1);
        $topic->setReplicaAssignment(0, [KAFKA_BROKER_ID]);
        $topic->setReplicaAssignment(1, [KAFKA_BROKER_ID]);

        $options = $client->newCreateTopicsOptions();
        $options->setOperationTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->createTopics([$topic], $options);

        $this->assertSame('test_admin_3', $result[0]->name);

        $options->setValidateOnly(true);
        $result = $client->createTopics([$topic], $options);

        $this->assertSame(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[0]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_3']);

        $this->assertNotNull($metaTopics['test_admin_3']);
        $this->assertCount(2, $metaTopics['test_admin_3']->getPartitions());
        foreach ($metaTopics['test_admin_3']->getPartitions() as $metaPartition) {
            $this->assertSame(KAFKA_BROKER_ID, $metaPartition->getReplicas()->current());
        }
    }

    /**
     * @depends testCreateTopicsWithReplicaAssignment
     */
    public function testCreatePartitionsWithReplicaAssignment(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $partition = new NewPartitions('test_admin_3', 4);
        $partition->setReplicaAssignment(0, [KAFKA_BROKER_ID]);
        $partition->setReplicaAssignment(1, [KAFKA_BROKER_ID]);

        $options = $client->newCreatePartitionsOptions();
        $options->setOperationTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->createPartitions([$partition], $options);

        $this->assertSame('test_admin_3', $result[0]->name);

        $options->setValidateOnly(true);
        $result = $client->createPartitions([$partition], $options);

        $this->assertSame(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[0]->error);

        $metaTopics = $this->getFilteredMetaTopics(['test_admin_3']);

        $this->assertCount(1, $metaTopics);
        $this->assertCount(4, $metaTopics['test_admin_3']->getPartitions());
        foreach ($metaTopics['test_admin_3']->getPartitions() as $metaPartition) {
            $this->assertSame(KAFKA_BROKER_ID, $metaPartition->getReplicas()->current());
        }
    }

    private function getFilteredMetaTopics(array $topicNames): array
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $metaTopics = [];
        $metadata = $producer->getMetadata(true, null, KAFKA_TEST_TIMEOUT_MS);
        foreach ($metadata->getTopics() as $topic) {
            if (in_array($topic->getTopic(), $topicNames, true)) {
                $metaTopics[$topic->getTopic()] = $topic;
            }
        }
        return $metaTopics;
    }

    private static function waitAfterTopicDeletion(): void
    {
        sleep(2);
    }

    public function testDescribeConfigs(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $configResource = new ConfigResource(RD_KAFKA_RESOURCE_BROKER, (string) KAFKA_BROKER_ID);

        $options = $client->newDescribeConfigsOptions();
        $options->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $options->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->describeConfigs([$configResource], $options);

        $configs = $this->getIndexedConfigEntries($result[0]->configs);

        $this->assertSame('111', $result[0]->name);

        $this->assertSame('111', $configs['broker.id']->value);
        $this->assertTrue($configs['broker.id']->isReadOnly);

        $this->assertSame('500', $configs['queued.max.requests']->value);
        $this->assertTrue($configs['queued.max.requests']->isDefault);
    }

    public function testDescribeConfigsWithEmptyParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/empty/');
        $this->expectExceptionMessageMatches('/resources/');
        $client->describeConfigs([]);
    }

    public function testDescribeConfigsWithInvalidParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches(ConfigResource::class);
        $this->expectExceptionMessageMatches('/resources/');
        $client->describeConfigs([new \stdClass()]);
    }

    public function testAlterConfigs(): void
    {
        // prepare
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('broker.version.fallback', '2.0.0');
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $configResource = new ConfigResource(RD_KAFKA_RESOURCE_BROKER, (string) KAFKA_BROKER_ID);
        $configResource->setConfig('max.connections.per.ip', (string) 500000);

        $alterConfigOptions = $client->newAlterConfigsOptions();
        $alterConfigOptions->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $alterConfigOptions->setBrokerId(KAFKA_BROKER_ID);

        $describeConfigsOptions = $client->newDescribeConfigsOptions();
        $describeConfigsOptions->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $describeConfigsOptions->setBrokerId(KAFKA_BROKER_ID);

        // alter config
        $result = $client->alterConfigs([$configResource], $alterConfigOptions);

        $this->assertSame('111', $result[0]->name);

        // check changes
        usleep(50 * 1000);
        $result = $client->describeConfigs([$configResource], $describeConfigsOptions);

        $this->assertSame('111', $result[0]->name);

        $configs = $this->getIndexedConfigEntries($result[0]->configs);

        $this->assertSame('500000', $configs['max.connections.per.ip']->value);
        $this->assertFalse($configs['max.connections.per.ip']->isDefault);

        // set config back to old value (deleteConfig not supported yet....)
        $configResource = new ConfigResource(RD_KAFKA_RESOURCE_BROKER, (string) KAFKA_BROKER_ID);
        $configResource->setConfig('max.connections.per.ip', (string) 2147483647);

        $result = $client->alterConfigs([$configResource], $alterConfigOptions);

        $this->assertSame('111', $result[0]->name);

        // check config changes
        usleep(50 * 1000);
        $result = $client->describeConfigs([$configResource], $describeConfigsOptions);

        $this->assertSame('111', $result[0]->name);

        $configs = $this->getIndexedConfigEntries($result[0]->configs);

        $this->assertSame('2147483647', $configs['max.connections.per.ip']->value);
    }

    public function testAlterConfigsWithEmptyParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/empty/');
        $this->expectExceptionMessageMatches('/resources/');
        $client->alterConfigs([]);
    }

    public function testAlterConfigsWithInvalidParameterShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches(ConfigResource::class);
        $this->expectExceptionMessageMatches('/resources/');
        $client->alterConfigs([new \stdClass()]);
    }

    public function testDeleteRecords(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.6.0');

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC_ADMIN);
        $topic->produce(0, 0, __METHOD__);
        $topic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);
        $client->getMetadata(true, null, KAFKA_TEST_TIMEOUT_MS);

        $deleteRecords = new DeleteRecords(
            new TopicPartition(KAFKA_TEST_TOPIC_ADMIN, 0, 1)
        );

        $deleteRecordsOptions = $client->newDeleteRecordsOptions();
        $deleteRecordsOptions->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $deleteRecordsOptions->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->deleteRecords([$deleteRecords], $deleteRecordsOptions);

        $this->assertCount(1, $result);
        $this->assertSame(KAFKA_TEST_TOPIC_ADMIN, $result[0]->getTopic());
        $this->assertSame(1, $result[0]->getOffset());
        $this->assertSame(0, $result[0]->getPartition());
    }

    public function testDeleteConsumerGroupOffset(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.6.0');

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC_ADMIN);
        $topic->produce(0, 0, __METHOD__);
        $topic->produce(0, 0, __METHOD__);
        $topic->produce(0, 0, __METHOD__);
        $topic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('group.id', __METHOD__);
        $conf->set('enable.auto.offset.store', 'false');

        $consumer = new KafkaConsumer($conf);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC_ADMIN, 0, RD_KAFKA_OFFSET_BEGINNING)]);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC_ADMIN);

        sleep(1);
        $topic->offsetStore(0, 1);

        $consumer->commit();
        $topicPartitions = $consumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC_ADMIN, 0)],
            KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertSame(2, $topicPartitions[0]->getOffset());

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $client = Client::fromConf($conf);
        $client->setWaitForResultEventTimeout(KAFKA_TEST_TIMEOUT_MS);

        $deleteGroupOffsets = new DeleteConsumerGroupOffsets(
            __METHOD__,
            new TopicPartition(KAFKA_TEST_TOPIC_ADMIN, 0, 1)
        );

        $deleteGroupOffsetsOptions = $client->newDeleteConsumerGroupOffsetsOptions();
        $deleteGroupOffsetsOptions->setRequestTimeout(KAFKA_TEST_TIMEOUT_MS);
        $deleteGroupOffsetsOptions->setBrokerId(KAFKA_BROKER_ID);

        $result = $client->deleteConsumerGroupOffsets($deleteGroupOffsets, $deleteGroupOffsetsOptions);

        $this->assertCount(1, $result);
        $this->assertSame(0, $result[0]->error);
        $this->assertSame(__METHOD__, $result[0]->name);
        $this->assertCount(1, $result[0]->partitions);
        $this->assertSame(0, $result[0]->partitions[0]->getPartition());
        $this->assertSame(-1001, $result[0]->partitions[0]->getOffset());
        $this->assertSame(KAFKA_TEST_TOPIC_ADMIN, $result[0]->partitions[0]->getTopic());
    }

    /**
     * @param ConfigEntry[] $configs
     * @return ConfigEntry[]
     * @throws Exception
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
