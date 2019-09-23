# Benchmarks

Benchmarks based on PHP74-RC1, librdkafka v1.0.0, ext latest master, ffi without preload enabled.

## FFI binding report (tag:ffi)

| benchmark     | subject                      | set | revs | iter | mem_peak   | time_rev     | comp_z_value | comp_deviation |
|---------------|------------------------------|-----|------|------|------------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message         | 0   | 100  | 0    | 1,126,816b | 28,559.080μs | +0.17σ       | +0.50%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 1    | 1,126,816b | 29,018.390μs | +0.73σ       | +2.11%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 2    | 1,126,816b | 28,003.740μs | -0.5σ        | -1.46%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 3    | 1,126,816b | 27,072.730μs | -1.63σ       | -4.73%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 4    | 1,126,816b | 29,436.700μs | +1.24σ       | +3.58%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 0    | 1,126,816b | 40,282.710μs | +0.21σ       | +0.25%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 1    | 1,126,816b | 40,797.960μs | +1.30σ       | +1.53%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 2    | 1,126,816b | 39,331.510μs | -1.8σ        | -2.12%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 3    | 1,126,816b | 40,268.610μs | +0.18σ       | +0.21%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 4    | 1,126,816b | 40,233.390μs | +0.11σ       | +0.13%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 0    | 1,126,824b | 33,475.950μs | -1.46σ       | -4.73%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 1    | 1,126,824b | 34,785.820μs | -0.31σ       | -1%            |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 2    | 1,126,824b | 36,462.480μs | +1.16σ       | +3.77%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 3    | 1,126,824b | 36,379.940μs | +1.09σ       | +3.54%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 4    | 1,126,824b | 34,577.010μs | -0.49σ       | -1.59%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 0    | 1,121,136b | 3,920.790μs  | -1.58σ       | -3.82%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 1    | 1,121,136b | 4,170.950μs  | +0.96σ       | +2.31%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 2    | 1,121,136b | 4,010.320μs  | -0.67σ       | -1.63%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 3    | 1,121,136b | 4,103.000μs  | +0.27σ       | +0.65%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 4    | 1,121,136b | 4,178.410μs  | +1.03σ       | +2.50%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 0    | 1,121,136b | 3,595.450μs  | -0.86σ       | -1.86%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 1    | 1,121,136b | 3,602.760μs  | -0.77σ       | -1.66%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 2    | 1,121,136b | 3,804.730μs  | +1.78σ       | +3.85%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 3    | 1,121,136b | 3,697.350μs  | +0.42σ       | +0.92%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 4    | 1,121,136b | 3,618.260μs  | -0.57σ       | -1.24%         |

## Extension binding report (tag:ext)

| benchmark     | subject                      | set | revs | iter | mem_peak | time_rev     | comp_z_value | comp_deviation |
|---------------|------------------------------|-----|------|------|----------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message         | 0   | 100  | 0    | 873,672b | 25,471.670μs | -1.12σ       | -2.37%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 1    | 873,672b | 26,516.180μs | +0.77σ       | +1.63%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 2    | 873,672b | 25,445.160μs | -1.17σ       | -2.48%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 3    | 873,672b | 26,813.440μs | +1.31σ       | +2.77%         |
| ConsumerBench | benchConsume1Message         | 0   | 100  | 4    | 873,672b | 26,209.270μs | +0.21σ       | +0.45%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 0    | 873,672b | 38,351.060μs | -0.74σ       | -0.79%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 1    | 873,672b | 39,070.590μs | +1.00σ       | +1.07%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 2    | 873,672b | 39,182.610μs | +1.27σ       | +1.36%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 3    | 873,672b | 38,581.030μs | -0.18σ       | -0.19%         |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 4    | 873,672b | 38,096.680μs | -1.35σ       | -1.45%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 0    | 873,688b | 26,896.910μs | -1.45σ       | -1.05%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 1    | 873,688b | 27,280.290μs | +0.49σ       | +0.36%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 2    | 873,688b | 27,066.080μs | -0.59σ       | -0.43%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 3    | 873,688b | 27,190.890μs | +0.04σ       | +0.03%         |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 4    | 873,688b | 27,481.700μs | +1.51σ       | +1.10%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 0    | 873,248b | 3,492.970μs  | -1.85σ       | -1.99%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 1    | 873,248b | 3,571.670μs  | +0.20σ       | +0.22%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 2    | 873,248b | 3,603.190μs  | +1.02σ       | +1.10%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 3    | 873,248b | 3,590.770μs  | +0.70σ       | +0.75%         |
| ProducerBench | benchProduce1Message         | 0   | 100  | 4    | 873,248b | 3,560.970μs  | -0.08σ       | -0.08%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 0    | 873,248b | 3,887.360μs  | +1.20σ       | +4.17%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 1    | 873,248b | 3,882.500μs  | +1.16σ       | +4.03%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 2    | 873,248b | 3,580.250μs  | -1.17σ       | -4.06%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 3    | 873,248b | 3,685.530μs  | -0.36σ       | -1.24%         |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 4    | 873,248b | 3,623.960μs  | -0.83σ       | -2.89%         |
