---
layout: default
title: Benchmarks
nav_order: 5
---

# Benchmarks

Benchmarks based on PHP 7.4.1, librdkafka v1.3.0, ext latest master (^4.0.2), ffi with preload enabled.

## FFI binding report (tag:ffi)

| benchmark     | subject                        | set | revs | iter | mem_peak | time_rev      | comp_z_value | comp_deviation |
|---------------|--------------------------------|-----|------|------|----------|---------------|--------------|----------------|
| ConsumerBench | benchConsume1Message           | 0   | 100  | 0    | 479,784b | 29,394.890μs  | -1.13σ       | -2.92%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 1    | 479,784b | 29,725.490μs  | -0.71σ       | -1.83%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 2    | 479,784b | 31,154.640μs  | +1.12σ       | +2.89%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 3    | 479,784b | 29,844.080μs  | -0.56σ       | -1.44%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 4    | 479,784b | 31,279.470μs  | +1.28σ       | +3.30%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 0    | 479,832b | 255,487.200μs | +0.86σ       | +2.15%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 1    | 479,832b | 247,956.000μs | -0.34σ       | -0.86%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 2    | 479,832b | 257,580.100μs | +1.19σ       | +2.99%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 3    | 479,832b | 249,775.100μs | -0.05σ       | -0.13%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 4    | 479,832b | 239,743.800μs | -1.65σ       | -4.14%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 0    | 479,784b | 42,396.600μs  | -1.33σ       | -0.91%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 1    | 479,784b | 42,739.600μs  | -0.16σ       | -0.11%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 2    | 479,784b | 43,232.430μs  | +1.53σ       | +1.04%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 3    | 479,784b | 42,972.210μs  | +0.64σ       | +0.44%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 4    | 479,784b | 42,585.910μs  | -0.68σ       | -0.47%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 0    | 479,832b | 37,907.850μs  | -1.2σ        | -2.76%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 1    | 479,832b | 40,578.270μs  | +1.78σ       | +4.09%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 2    | 479,832b | 38,755.390μs  | -0.25σ       | -0.59%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 3    | 479,832b | 39,180.100μs  | +0.22σ       | +0.50%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 4    | 479,832b | 38,499.290μs  | -0.54σ       | -1.24%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 0    | 479,832b | 244,813.500μs | +1.28σ       | +1.85%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 1    | 479,832b | 241,840.500μs | +0.42σ       | +0.61%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 2    | 479,832b | 238,044.000μs | -0.67σ       | -0.97%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 3    | 479,832b | 242,216.800μs | +0.53σ       | +0.77%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 4    | 479,832b | 234,905.400μs | -1.57σ       | -2.27%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 0    | 454,920b | 3,749.850μs   | +0.43σ       | +1.42%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 1    | 454,920b | 3,872.760μs   | +1.44σ       | +4.75%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 2    | 454,920b | 3,515.240μs   | -1.49σ       | -4.92%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 3    | 454,920b | 3,617.600μs   | -0.65σ       | -2.16%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 4    | 454,920b | 3,731.050μs   | +0.28σ       | +0.91%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 0    | 454,920b | 3,819.580μs   | -1.03σ       | -3.24%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 1    | 454,920b | 3,825.410μs   | -0.98σ       | -3.09%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 2    | 454,920b | 4,083.430μs   | +1.09σ       | +3.45%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 3    | 454,920b | 4,106.910μs   | +1.28σ       | +4.04%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 4    | 454,920b | 3,901.240μs   | -0.37σ       | -1.17%         |

## Extension binding report (tag:ext)

| benchmark     | subject                        | set | revs | iter | mem_peak | time_rev     | comp_z_value | comp_deviation |
|---------------|--------------------------------|-----|------|------|----------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message           | 0   | 100  | 0    | 785,728b | 30,010.170μs | -0.33σ       | -1.04%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 1    | 785,728b | 29,674.010μs | -0.69σ       | -2.15%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 2    | 785,728b | 31,126.280μs | +0.85σ       | +2.64%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 3    | 785,728b | 31,679.850μs | +1.44σ       | +4.47%         |
| ConsumerBench | benchConsume1Message           | 0   | 100  | 4    | 785,728b | 29,133.150μs | -1.27σ       | -3.93%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 0    | 785,776b | 29,833.000μs | -0.33σ       | -0.88%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 1    | 785,776b | 29,626.100μs | -0.58σ       | -1.57%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 2    | 785,776b | 29,081.200μs | -1.25σ       | -3.38%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 3    | 785,776b | 30,495.500μs | +0.49σ       | +1.32%         |
| ConsumerBench | benchConsumeCallback1Message   | 0   | 10   | 4    | 785,776b | 31,454.800μs | +1.66σ       | +4.51%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 0    | 785,728b | 42,463.470μs | -1.09σ       | -1.88%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 1    | 785,728b | 44,636.270μs | +1.82σ       | +3.14%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 2    | 785,728b | 43,407.580μs | +0.17σ       | +0.30%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 3    | 785,728b | 43,078.880μs | -0.27σ       | -0.46%         |
| ConsumerBench | benchConsume100Messages        | 0   | 100  | 4    | 785,728b | 42,809.580μs | -0.63σ       | -1.08%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 0    | 785,776b | 27,997.180μs | -0.93σ       | -2.22%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 1    | 785,776b | 28,090.750μs | -0.8σ        | -1.89%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 2    | 785,776b | 29,899.110μs | +1.86σ       | +4.42%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 3    | 785,776b | 28,668.090μs | +0.05σ       | +0.12%         |
| ConsumerBench | benchConsumeBatch100Messages   | 0   | 100  | 4    | 785,776b | 28,507.890μs | -0.18σ       | -0.44%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 0    | 785,776b | 29,175.000μs | +0.67σ       | +1.30%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 1    | 785,776b | 28,159.700μs | -1.16σ       | -2.23%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 2    | 785,776b | 29,450.200μs | +1.17σ       | +2.25%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 3    | 785,776b | 28,117.600μs | -1.24σ       | -2.37%         |
| ConsumerBench | benchConsumeCallback100Message | 0   | 10   | 4    | 785,776b | 29,104.900μs | +0.55σ       | +1.05%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 0    | 785,304b | 3,788.520μs  | -1.25σ       | -3.29%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 1    | 785,304b | 4,104.890μs  | +1.81σ       | +4.79%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 2    | 785,304b | 3,915.280μs  | -0.02σ       | -0.05%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 3    | 785,304b | 3,886.520μs  | -0.3σ        | -0.79%         |
| ProducerBench | benchProduce1Message           | 0   | 100  | 4    | 785,304b | 3,891.810μs  | -0.25σ       | -0.65%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 0    | 785,304b | 4,116.620μs  | +1.41σ       | +3.25%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 1    | 785,304b | 4,056.710μs  | +0.76σ       | +1.75%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 2    | 785,304b | 3,970.290μs  | -0.18σ       | -0.42%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 3    | 785,304b | 3,853.540μs  | -1.45σ       | -3.35%         |
| ProducerBench | benchProduce100Messages        | 0   | 100  | 4    | 785,304b | 3,937.910μs  | -0.53σ       | -1.23%         |
