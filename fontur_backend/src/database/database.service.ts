import {TypeOrmModule} from '@nestjs/typeorm'
import { Configuration } from 'src/config/config.keys'
import { ConfigModule } from 'src/config/config.module'
import { ConfigService } from 'src/config/config.service'
import { ConnectionOptions } from 'typeorm'

export const databaseProviders = [
    TypeOrmModule.forRootAsync({
        imports: [ConfigModule],
        inject: [ConfigService],
        async useFactory(config: ConfigService){
            return {
                ssl:true,
                type: 'postgres' as 'postgres',
                host: config.get(Configuration.DB_HOST),
                database: config.get(Configuration.DB_DATABASE),
                port: parseInt(config.get(Configuration.DB_PORT)),
                username: config.get(Configuration.DB_USERNAME),
                password: config.get(Configuration.DB_PASSWORD),
                entities: [
                    __dirname + '/../**/*.entity{.ts,.js}'
                ],
                migrations : [
                    __dirname + '/migrations/*{.ts,.js}'
                ]
            } as ConnectionOptions
        }
    })
]