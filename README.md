# IDUS 백패커 PHP 코딩 테스트

### API 문서
API 문서는 아래 경로에서 확인 가능합니다.  
https://documenter.getpostman.com/view/2723861/UV5ddZfu

### Docker
컨테이너 실행 후 composer update가 필요합니다.
```
docker compose up -d
docker exec -it idus-php sh -c "cd /idus/html; composer update"
```

### 개발 환경
```
NginX - nginx/1.21.3
MySQL - 8.0.27
PHP - 7.4.25
Laravel - 8.5.3
```

### 참고사항
Docker WSL2 환경(Windows, MacOS) 에서는 외부 볼륨 이슈로 인해 속도 저하가 있습니다. 참고 부탁드립니다.

Laravel의 Eloquent ORM을 사용하였으며, 쿼리는 아래의 경로에 로깅됩니다.
```
/php/src/storage/logs/sql-*.log
```
