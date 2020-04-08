## Steps

1. Download **BoosterBox.zip** to `~/@booster/tkBox/`
2. Move `.env.example` to `~/@booster/code/TrapperKeeper/.env`
3. Edit APP, MYSQL, and REDIS
4. `/etc/redis/redis.conf`
   - Change `bind 127.0.0.1 ::1` to `bind 127.0.0.1 192.168.10.2 ::1`

-
