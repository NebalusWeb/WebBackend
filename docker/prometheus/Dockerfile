FROM prom/prometheus:v3.0.0 AS base
WORKDIR /etc/prometheus
COPY ./docker/prometheus/prometheus.yml /etc/prometheus/prometheus.yml
CMD ["--config.file=/etc/prometheus/prometheus.yml"]