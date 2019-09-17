# Benchmarks

Benchmarks based on PHP74-RC1, librdkafka v1.0.0, ext & ffi latest master.

## FFI binding report (tag:ffi)

| benchmark     | subject                 | set | revs | iter | mem_peak   | time_rev     | comp_z_value | comp_deviation |
|---------------|-------------------------|-----|------|------|------------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message    | 0   | 100  | 0    | 1,116,440b | 26,294.860μs | +0.54σ       | +1.16%         |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 1    | 1,116,440b | 26,322.230μs | +0.59σ       | +1.26%         |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 2    | 1,116,440b | 25,377.340μs | -1.1σ        | -2.37%         |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 3    | 1,116,440b | 26,689.800μs | +1.24σ       | +2.68%         |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 4    | 1,116,440b | 25,284.020μs | -1.27σ       | -2.73%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 0    | 1,116,440b | 37,202.170μs | +0.52σ       | +0.41%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 1    | 1,116,440b | 36,589.170μs | -1.57σ       | -1.25%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 2    | 1,116,440b | 36,833.570μs | -0.74σ       | -0.59%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 3    | 1,116,440b | 37,252.650μs | +0.69σ       | +0.54%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 4    | 1,116,440b | 37,377.320μs | +1.11σ       | +0.88%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 0    | 1,112,584b | 3,949.540μs  | -0.92σ       | -2.48%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 1    | 1,112,584b | 4,107.640μs  | +0.53σ       | +1.43%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 2    | 1,112,584b | 4,124.900μs  | +0.69σ       | +1.85%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 3    | 1,112,584b | 3,892.930μs  | -1.44σ       | -3.88%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 4    | 1,112,584b | 4,174.590μs  | +1.15σ       | +3.08%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 0    | 1,112,584b | 5,724.040μs  | -0.31σ       | -0.59%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 1    | 1,112,584b | 5,767.160μs  | +0.09σ       | +0.16%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 2    | 1,112,584b | 5,943.050μs  | +1.69σ       | +3.22%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 3    | 1,112,584b | 5,600.800μs  | -1.43σ       | -2.73%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 4    | 1,112,584b | 5,753.730μs  | -0.04σ       | -0.07%         |

## Extension binding report (tag:ext)

| benchmark     | subject                 | set | revs | iter | mem_peak | time_rev     | comp_z_value | comp_deviation |
|---------------|-------------------------|-----|------|------|----------|--------------|--------------|----------------|
| ConsumerBench | benchConsume1Message    | 0   | 100  | 0    | 873,672b | 24,403.420μs | -0.17σ       | -0.2%          |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 1    | 873,672b | 24,167.610μs | -1σ          | -1.16%         |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 2    | 873,672b | 24,137.930μs | -1.1σ        | -1.28%         |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 3    | 873,672b | 24,863.220μs | +1.44σ       | +1.68%         |
| ConsumerBench | benchConsume1Message    | 0   | 100  | 4    | 873,672b | 24,687.290μs | +0.83σ       | +0.96%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 0    | 873,672b | 35,833.390μs | +0.78σ       | +0.64%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 1    | 873,672b | 35,641.940μs | +0.13σ       | +0.10%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 2    | 873,672b | 35,996.290μs | +1.34σ       | +1.10%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 3    | 873,672b | 35,234.090μs | -1.27σ       | -1.04%         |
| ConsumerBench | benchConsume100Messages | 0   | 100  | 4    | 873,672b | 35,317.830μs | -0.98σ       | -0.81%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 0    | 873,248b | 3,528.540μs  | -0.66σ       | -1.59%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 1    | 873,248b | 3,519.670μs  | -0.76σ       | -1.84%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 2    | 873,248b | 3,580.760μs  | -0.06σ       | -0.14%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 3    | 873,248b | 3,753.380μs  | +1.94σ       | +4.68%         |
| ProducerBench | benchProduce1Message    | 0   | 100  | 4    | 873,248b | 3,546.100μs  | -0.46σ       | -1.1%          |
| ProducerBench | benchProduce100Messages | 0   | 100  | 0    | 873,248b | 5,469.110μs  | -0.55σ       | -1.21%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 1    | 873,248b | 5,586.840μs  | +0.42σ       | +0.91%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 2    | 873,248b | 5,609.810μs  | +0.61σ       | +1.33%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 3    | 873,248b | 5,680.360μs  | +1.19σ       | +2.60%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 4    | 873,248b | 5,335.190μs  | -1.66σ       | -3.63%         |
