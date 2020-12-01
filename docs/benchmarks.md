# Benchmarks

Some benchmarks based on PHP 7.4.12, librdkafka v1.5.2 and librdkafka binding via extension latest master (4.0.5-dev) vs via FFI with preload enabled.

## Comparison FFI <> Extension

![benchmarks](img/benchmarks.png)


| benchmark     | subject                                         | set | revs | tag:ffi:mean | tag:ext:mean |
|---------------|-------------------------------------------------|-----|------|--------------|--------------|
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 46,107.726μs | 45,096.940μs |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 44,515.082μs | 44,588.154μs |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 74,666.572μs | 69,413.848μs |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 75,043.452μs | 71,883.104μs |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 55,729.572μs | 47,300.918μs |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 55,595.076μs | 45,853.820μs |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 8,855.272μs  | 8,759.604μs  |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 7,908.822μs  | 7,849.658μs  |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 10,502.396μs | 8,361.642μs  |

## Details FFI report (tag:ffi)

| benchmark     | subject                                         | set | revs | iter | mem_peak | time_rev     | comp_z_value | comp_deviation |
|---------------|-------------------------------------------------|-----|------|------|----------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 0    | 488,488b | 47,685.410μs | +1.66σ       | +3.42%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 1    | 488,488b | 45,422.800μs | -0.72σ       | -1.49%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 2    | 488,488b | 46,199.460μs | +0.10σ       | +0.20%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 3    | 488,488b | 46,348.450μs | +0.25σ       | +0.52%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 4    | 488,488b | 44,882.510μs | -1.29σ       | -2.66%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 0    | 525,760b | 44,271.400μs | -0.22σ       | -0.55%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 1    | 525,760b | 43,337.760μs | -1.07σ       | -2.64%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 2    | 525,760b | 46,607.490μs | +1.90σ       | +4.70%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 3    | 525,760b | 44,085.260μs | -0.39σ       | -0.97%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 4    | 525,760b | 44,273.500μs | -0.22σ       | -0.54%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 0    | 488,488b | 73,739.290μs | -0.55σ       | -1.24%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 1    | 488,488b | 75,791.660μs | +0.67σ       | +1.51%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 2    | 488,488b | 73,237.580μs | -0.85σ       | -1.91%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 3    | 488,488b | 77,443.130μs | +1.64σ       | +3.72%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 4    | 488,488b | 73,121.200μs | -0.91σ       | -2.07%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 0    | 488,736b | 73,983.490μs | -0.7σ        | -1.41%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 1    | 488,736b | 73,958.510μs | -0.72σ       | -1.45%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 2    | 488,736b | 77,794.580μs | +1.82σ       | +3.67%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 3    | 488,736b | 75,583.260μs | +0.36σ       | +0.72%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 4    | 488,736b | 73,897.420μs | -0.76σ       | -1.53%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 0    | 488,520b | 55,756.600μs | +0.02σ       | +0.05%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 1    | 488,520b | 57,059.860μs | +0.91σ       | +2.39%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 2    | 488,520b | 57,205.070μs | +1.01σ       | +2.65%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 3    | 488,520b | 55,499.570μs | -0.16σ       | -0.41%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 4    | 488,520b | 53,126.760μs | -1.77σ       | -4.67%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 0    | 525,760b | 54,018.900μs | -1.03σ       | -2.84%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 1    | 525,760b | 56,556.670μs | +0.63σ       | +1.73%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 2    | 525,760b | 55,891.640μs | +0.19σ       | +0.53%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 3    | 525,760b | 53,731.210μs | -1.22σ       | -3.35%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 4    | 525,760b | 57,776.960μs | +1.42σ       | +3.92%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 0    | 466,912b | 8,910.150μs  | +0.25σ       | +0.62%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 1    | 466,912b | 9,255.640μs  | +1.82σ       | +4.52%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 2    | 466,912b | 8,695.220μs  | -0.73σ       | -1.81%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 3    | 466,912b | 8,776.320μs  | -0.36σ       | -0.89%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 4    | 466,912b | 8,639.030μs  | -0.98σ       | -2.44%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 0    | 466,912b | 7,674.560μs  | -0.94σ       | -2.96%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 1    | 466,912b | 8,245.910μs  | +1.35σ       | +4.26%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 2    | 466,912b | 8,158.350μs  | +1.00σ       | +3.16%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 3    | 466,912b | 7,637.510μs  | -1.09σ       | -3.43%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 4    | 466,912b | 7,827.780μs  | -0.32σ       | -1.02%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 0    | 586,200b | 10,791.340μs | +0.96σ       | +2.75%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 1    | 586,200b | 10,260.960μs | -0.8σ        | -2.3%          |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 2    | 586,200b | 10,911.010μs | +1.36σ       | +3.89%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 3    | 586,200b | 10,417.670μs | -0.28σ       | -0.81%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 4    | 586,200b | 10,131.000μs | -1.23σ       | -3.54%         |

## Details Extension report (tag:ext)

| benchmark     | subject                                         | set | revs | iter | mem_peak   | time_rev     | comp_z_value | comp_deviation |
|---------------|-------------------------------------------------|-----|------|------|------------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 0    | 1,400,560b | 44,567.040μs | -0.93σ       | -1.18%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 1    | 1,400,560b | 45,651.450μs | +0.97σ       | +1.23%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 2    | 1,400,560b | 45,231.240μs | +0.23σ       | +0.30%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 3    | 1,400,560b | 44,303.490μs | -1.39σ       | -1.76%         |
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 4    | 1,400,560b | 45,731.480μs | +1.11σ       | +1.41%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 0    | 1,400,592b | 45,259.580μs | +0.79σ       | +1.51%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 1    | 1,400,592b | 45,741.460μs | +1.35σ       | +2.59%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 2    | 1,400,592b | 44,645.190μs | +0.07σ       | +0.13%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 3    | 1,400,592b | 43,859.620μs | -0.85σ       | -1.63%         |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 4    | 1,400,592b | 43,434.920μs | -1.35σ       | -2.59%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 0    | 1,400,560b | 68,508.970μs | -1.16σ       | -1.3%          |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 1    | 1,400,560b | 69,357.410μs | -0.07σ       | -0.08%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 2    | 1,400,560b | 69,344.060μs | -0.09σ       | -0.1%          |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 3    | 1,400,560b | 70,840.330μs | +1.84σ       | +2.06%         |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 4    | 1,400,560b | 69,018.470μs | -0.51σ       | -0.57%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 0    | 1,400,624b | 71,994.990μs | +0.24σ       | +0.16%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 1    | 1,400,624b | 71,201.040μs | -1.46σ       | -0.95%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 2    | 1,400,624b | 72,480.170μs | +1.28σ       | +0.83%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 3    | 1,400,624b | 72,228.240μs | +0.74σ       | +0.48%         |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 4    | 1,400,624b | 71,511.080μs | -0.8σ        | -0.52%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 0    | 1,400,592b | 48,396.030μs | +1.03σ       | +2.32%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 1    | 1,400,592b | 47,931.280μs | +0.59σ       | +1.33%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 2    | 1,400,592b | 45,829.000μs | -1.38σ       | -3.11%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 3    | 1,400,592b | 48,147.970μs | +0.79σ       | +1.79%         |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 4    | 1,400,592b | 46,200.310μs | -1.03σ       | -2.33%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 0    | 1,400,592b | 46,953.640μs | +1.14σ       | +2.40%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 1    | 1,400,592b | 44,325.330μs | -1.58σ       | -3.33%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 2    | 1,400,592b | 45,583.250μs | -0.28σ       | -0.59%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 3    | 1,400,592b | 46,844.910μs | +1.02σ       | +2.16%         |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 4    | 1,400,592b | 45,561.970μs | -0.3σ        | -0.64%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 0    | 1,400,136b | 8,666.770μs  | -0.56σ       | -1.06%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 1    | 1,400,136b | 8,571.540μs  | -1.13σ       | -2.15%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 2    | 1,400,136b | 8,684.310μs  | -0.45σ       | -0.86%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 3    | 1,400,136b | 9,051.050μs  | +1.75σ       | +3.33%         |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 4    | 1,400,136b | 8,824.350μs  | +0.39σ       | +0.74%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 0    | 1,400,136b | 8,214.930μs  | +1.50σ       | +4.65%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 1    | 1,400,136b | 8,021.700μs  | +0.71σ       | +2.19%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 2    | 1,400,136b | 7,804.970μs  | -0.18σ       | -0.57%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 3    | 1,400,136b | 7,533.130μs  | -1.3σ        | -4.03%         |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 4    | 1,400,136b | 7,673.560μs  | -0.72σ       | -2.24%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 0    | 1,400,264b | 8,310.200μs  | -0.27σ       | -0.62%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 1    | 1,400,264b | 8,547.470μs  | +0.98σ       | +2.22%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 2    | 1,400,264b | 8,586.230μs  | +1.19σ       | +2.69%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 3    | 1,400,264b | 8,296.720μs  | -0.34σ       | -0.78%         |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 4    | 1,400,264b | 8,067.590μs  | -1.56σ       | -3.52%         |

