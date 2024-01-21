docker run --name hyperf \
-v ./:/data/project \
-p 9501:9501 \
--workdir /data/project -it --rm \
--privileged -u root \
--entrypoint /bin/sh \
hyperf/hyperf:8.2-alpine-v3.18-swoole