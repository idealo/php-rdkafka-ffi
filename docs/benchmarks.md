---
layout: default
title: Benchmarks
nav_order: 5
---

# Benchmarks

Benchmarks based on PHP 7.4.1, librdkafka v1.3.0, ext latest master (4.0.3-dev), ffi with preload enabled.

## FFI binding report (tag:ffi)

| benchmark     | subject                                         | set | revs | iter | mem_peak | time_rev     | comp_z_value | comp_deviation |
|---------------|-------------------------------------------------|-----|------|------|----------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 0    | 484,456b | 27,864.920μs | -0.66σ       | -1.61%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 1    | 484,456b | 28,127.860μs | -0.28σ       | -0.68%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 2    | 484,456b | 27,966.430μs | -0.51σ       | -1.25%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 3    | 484,456b | 27,947.380μs | -0.54σ       | -1.32%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 4    | 484,456b | 29,699.110μs | +1.98σ       | +4.87%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 0    | 522,248b | 29,290.690μs | +1.43σ       | +2.78%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 1    | 522,248b | 28,289.090μs | -0.38σ       | -0.74%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 2    | 522,248b | 28,999.610μs | +0.90σ       | +1.75%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 3    | 522,248b | 27,832.030μs | -1.2σ        | -2.34%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 4    | 522,248b | 28,086.900μs | -0.74σ       | -1.45%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 0    | 484,456b | 39,899.100μs | +0.59σ       | +0.38%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 1    | 484,456b | 39,794.360μs | +0.18σ       | +0.12%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 2    | 484,456b | 39,953.910μs | +0.81σ       | +0.52%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 3    | 484,456b | 39,250.000μs | -1.96σ       | -1.25%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 4    | 484,456b | 39,845.240μs | +0.38σ       | +0.24%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 0    | 487,664b | 40,179.520μs | -0.95σ       | -2.23%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 1    | 487,664b | 41,566.060μs | +0.49σ       | +1.14%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 2    | 487,664b | 42,548.670μs | +1.50σ       | +3.53%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 3    | 487,664b | 41,300.000μs | +0.21σ       | +0.49%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 4    | 487,664b | 39,891.560μs | -1.25σ       | -2.93%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 0    | 484,504b | 31,337.630μs | -1.07σ       | -2.42%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 1    | 484,504b | 31,914.840μs | -0.28σ       | -0.63%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 2    | 484,504b | 32,159.880μs | +0.06σ       | +0.14%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 3    | 484,504b | 33,465.880μs | +1.86σ       | +4.20%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 4    | 484,504b | 31,703.430μs | -0.57σ       | -1.29%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 0    | 522,248b | 35,083.970μs | -0.45σ       | -1.02%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 1    | 522,248b | 36,738.230μs | +1.62σ       | +3.65%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 2    | 522,248b | 34,887.290μs | -0.7σ        | -1.57%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 3    | 522,248b | 34,552.140μs | -1.12σ       | -2.52%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 4    | 522,248b | 35,965.160μs | +0.65σ       | +1.47%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 0    | 463,104b | 3,758.360μs  | -0.19σ       | -0.47%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 1    | 463,104b | 3,860.560μs  | +0.91σ       | +2.23%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 2    | 463,104b | 3,604.400μs  | -1.86σ       | -4.55%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 3    | 463,104b | 3,836.530μs  | +0.65σ       | +1.60%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 4    | 463,104b | 3,821.510μs  | +0.49σ       | +1.20%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 0    | 463,104b | 3,987.200μs  | +1.48σ       | +3.72%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 1    | 463,104b | 3,850.450μs  | +0.06σ       | +0.16%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 2    | 463,104b | 3,682.650μs  | -1.67σ       | -4.2%          |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 3    | 463,104b | 3,859.870μs  | +0.16σ       | +0.40%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 4    | 463,104b | 3,841.340μs  | -0.03σ       | -0.08%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 0    | 582,736b | 5,587.570μs  | -0.2σ        | -0.47%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 1    | 582,736b | 5,627.670μs  | +0.10σ       | +0.25%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 2    | 582,736b | 5,399.930μs  | -1.61σ       | -3.81%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 3    | 582,736b | 5,638.700μs  | +0.19σ       | +0.44%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 4    | 582,736b | 5,815.480μs  | +1.52σ       | +3.59%         |

## Extension binding report (tag:ext)

| benchmark     | subject                                         | set | revs | iter | mem_peak | time_rev     | comp_z_value | comp_deviation |
|---------------|-------------------------------------------------|-----|------|------|----------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 0    | 785,728b | 27,517.750μs | -0.58σ       | -0.88%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 1    | 785,728b | 27,388.620μs | -0.88σ       | -1.34%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 2    | 785,728b | 28,076.380μs | +0.74σ       | +1.14%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 3    | 785,728b | 28,437.340μs | +1.60σ       | +2.44%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 4    | 785,728b | 27,385.800μs | -0.89σ       | -1.35%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 0    | 785,776b | 27,079.990μs | -0.89σ       | -2.72%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 1    | 785,776b | 26,608.990μs | -1.45σ       | -4.42%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 2    | 785,776b | 28,148.360μs | +0.36σ       | +1.11%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 3    | 785,776b | 28,560.720μs | +0.85σ       | +2.59%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 4    | 785,776b | 28,794.740μs | +1.12σ       | +3.43%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 0    | 785,728b | 38,477.190μs | -0.65σ       | -1.05%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 1    | 785,728b | 40,077.640μs | +1.89σ       | +3.06%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 2    | 785,728b | 38,295.750μs | -0.94σ       | -1.52%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 3    | 785,728b | 38,658.960μs | -0.36σ       | -0.58%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 4    | 785,728b | 38,922.290μs | +0.06σ       | +0.09%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 0    | 785,824b | 38,936.770μs | -0.99σ       | -0.54%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 1    | 785,824b | 38,857.580μs | -1.36σ       | -0.74%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 2    | 785,824b | 39,413.160μs | +1.24σ       | +0.68%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 3    | 785,824b | 39,270.870μs | +0.57σ       | +0.31%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 4    | 785,824b | 39,265.810μs | +0.55σ       | +0.30%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 0    | 785,776b | 28,245.120μs | +1.23σ       | +3.57%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 1    | 785,776b | 27,413.020μs | +0.18σ       | +0.52%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 2    | 785,776b | 27,969.150μs | +0.88σ       | +2.55%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 3    | 785,776b | 26,190.900μs | -1.36σ       | -3.97%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 4    | 785,776b | 26,544.580μs | -0.92σ       | -2.67%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 0    | 785,776b | 27,721.220μs | +0.25σ       | +0.37%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 1    | 785,776b | 27,122.050μs | -1.24σ       | -1.8%          |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 2    | 785,776b | 28,265.170μs | +1.61σ       | +2.34%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 3    | 785,776b | 27,274.250μs | -0.86σ       | -1.25%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 4    | 785,776b | 27,714.870μs | +0.24σ       | +0.35%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 0    | 785,304b | 3,553.950μs  | -1.39σ       | -2.76%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 1    | 785,304b | 3,696.680μs  | +0.57σ       | +1.14%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 2    | 785,304b | 3,651.610μs  | -0.05σ       | -0.09%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 3    | 785,304b | 3,765.880μs  | +1.52σ       | +3.03%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 4    | 785,304b | 3,606.750μs  | -0.66σ       | -1.32%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 0    | 785,304b | 3,705.950μs  | -1.41σ       | -3.69%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 1    | 785,304b | 3,878.600μs  | +0.31σ       | +0.80%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 2    | 785,304b | 3,995.870μs  | +1.47σ       | +3.85%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 3    | 785,304b | 3,770.240μs  | -0.77σ       | -2.02%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 4    | 785,304b | 3,888.760μs  | +0.41σ       | +1.06%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 0    | 785,496b | 4,286.790μs  | +0.35σ       | +0.86%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 1    | 785,496b | 4,286.810μs  | +0.35σ       | +0.86%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 2    | 785,496b | 4,398.450μs  | +1.44σ       | +3.49%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 3    | 785,496b | 4,184.740μs  | -0.63σ       | -1.54%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 4    | 785,496b | 4,094.260μs  | -1.51σ       | -3.67%         |
