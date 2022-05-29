import {IsNotEmpty} from 'class-validator'
import { RoleType } from 'src/modules/role/role_type.enum'
import { UserDetails } from '../user._details.entity'

export class UserDto{
    @IsNotEmpty()
    id: number   

    @IsNotEmpty()
    username: string

    @IsNotEmpty()
    email:string

    @IsNotEmpty()
    roles:RoleType[]

    @IsNotEmpty()
    details: UserDetails
}