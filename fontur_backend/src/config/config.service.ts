import * as fs from 'fs'
import {parse} from 'dotenv'

export class ConfigService {
    private readonly envConfig: {
        [key: string]: string
    }

    constructor(){
        const isDevEnv = process.env.NODE_ENV !== 'producction'

        if(isDevEnv){
            const envFilePath = __dirname + '/../../.env'// path actual
            const existPath = fs.existsSync(envFilePath)

            if(!existPath){
                console.log('.env no existe');
                process.exit(0)       
            }

            this.envConfig = parse(fs.readFileSync(envFilePath))
        }else{
            this.envConfig = {
                ṔORT : process.env.PORT
            }
        }
    }

    get(key:string): string {
        return this.envConfig[key]
    }
}