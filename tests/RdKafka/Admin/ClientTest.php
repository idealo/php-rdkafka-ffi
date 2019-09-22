<?php

namespace RdKafka\Admin;

use PHPUnit\Framework\TestCase;
use RdKafka\Conf;

/**
 * @covers \RdKafka\Admin\Client
 * @covers \RdKafka\Admin\CreatePartitionsOptions
 * @covers \RdKafka\Admin\CreateTopicsOptions
 * @covers \RdKafka\Admin\DeleteTopic
 * @covers \RdKafka\Admin\DeleteTopicsOptions
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
        $options = $client->newDeleteTopicsOptions();
        $options->setRequestTimeout(5000);
        $options->setOperationTimeout(5000);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $client->deleteTopics(
            [
                new DeleteTopic('test_admin_1'),
                new DeleteTopic('test_admin_2'),
            ],
            $options
        );
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
        $options->setOperationTimeout(5000);
        $options->setRequestTimeout(5000);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->createTopics($topics, $options);

        $this->assertEquals('test_admin_1', $result[0]->name);
        $this->assertEquals('test_admin_2', $result[1]->name);

        $options->setValidateOnly(true);
        $result = $client->createTopics($topics, $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[0]->error);
        $this->assertEquals(RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS, $result[1]->error);

        $metaTopics = [];
        $metadata = $client->getMetadata(true, null, (int)KAFKA_TEST_TIMEOUT_MS);
        foreach ($metadata->getTopics() as $topic) {
            if (in_array($topic->getTopic(), ['test_admin_1', 'test_admin_2'])) {
                $metaTopics[$topic->getTopic()] = $topic;
            }
        }
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
        $options->setOperationTimeout(5000);
        $options->setRequestTimeout(5000);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->createPartitions($partitions, $options);

        $this->assertEquals('test_admin_1', $result[0]->name);
        $this->assertEquals('test_admin_2', $result[1]->name);

        $options->setValidateOnly(true);
        $result = $client->createPartitions($partitions, $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[0]->error);
        $this->assertEquals(RD_KAFKA_RESP_ERR_INVALID_PARTITIONS, $result[1]->error);

        $metaTopics = [];
        $metadata = $client->getMetadata(true, null, (int)KAFKA_TEST_TIMEOUT_MS);
        foreach ($metadata->getTopics() as $topic) {
            if (in_array($topic->getTopic(), ['test_admin_1', 'test_admin_2'])) {
                $metaTopics[$topic->getTopic()] = $topic;
            }
        }
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
        $options->setOperationTimeout(5000);
        $options->setRequestTimeout(5000);
        $options->setBrokerId((int)KAFKA_BROKER_ID);

        $result = $client->deleteTopics($topics, $options);

        $this->assertEquals('test_admin_1', $result[0]->name);
        $this->assertEquals('test_admin_2', $result[1]->name);

        $result = $client->deleteTopics($topics, $options);

        $this->assertEquals(RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART, $result[0]->error);
        $this->assertEquals(RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART, $result[1]->error);
    }
}
