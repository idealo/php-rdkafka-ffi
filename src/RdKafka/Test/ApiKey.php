<?php

declare(strict_types=1);

namespace RdKafka\Test;

/**
 * @link https://kafka.apache.org/protocol#protocol_api_keys
 */
class ApiKey
{
    public const None = -1;
    public const Produce = 0;
    public const Fetch = 1;
    public const Offset = 2;
    public const Metadata = 3;
    public const LeaderAndIsr = 4;
    public const StopReplica = 5;
    public const UpdateMetadata = 6;
    public const ControlledShutdown = 7;
    public const OffsetCommit = 8;
    public const OffsetFetch = 9;
    public const FindCoordinator = 10;
    public const JoinGroup = 11;
    public const Heartbeat = 12;
    public const LeaveGroup = 13;
    public const SyncGroup = 14;
    public const DescribeGroups = 15;
    public const ListGroups = 16;
    public const SaslHandshake = 17;
    public const ApiVersion = 18;
    public const CreateTopics = 19;
    public const DeleteTopics = 20;
    public const DeleteRecords = 21;
    public const InitProducerId = 22;
    public const OffsetForLeaderEpoch = 23;
    public const AddPartitionsToTxn = 24;
    public const AddOffsetsToTxn = 25;
    public const EndTxn = 26;
    public const WriteTxnMarkers = 27;
    public const TxnOffsetCommit = 28;
    public const DescribeAcls = 29;
    public const CreateAcls = 30;
    public const DeleteAcls = 31;
    public const DescribeConfigs = 32;
    public const AlterConfigs = 33;
    public const AlterReplicaLogDirs = 34;
    public const DescribeLogDirs = 35;
    public const SaslAuthenticate = 36;
    public const CreatePartitions = 37;
    public const CreateDelegationToken = 38;
    public const RenewDelegationToken = 39;
    public const ExpireDelegationToken = 40;
    public const DescribeDelegationToken = 41;
    public const DeleteGroups = 42;
}
