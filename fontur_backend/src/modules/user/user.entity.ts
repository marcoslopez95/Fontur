import {BaseEntity, Column, Entity, JoinColumn, JoinTable, ManyToMany, OneToOne, PrimaryGeneratedColumn} from 'typeorm'
import { Role } from '../role/role.entity'
import { UserDetails } from './user._details.entity'

@Entity('users')
export class User  extends BaseEntity{

    @PrimaryGeneratedColumn('increment')
    id: number

    @Column({
        type: 'varchar',
        unique: true,
        nullable: false
    })
    username:string

    @Column({
        type:'varchar',
        unique: true,
        nullable: false
    })
    email:string

    @Column({
        type:'varchar',
        nullable: false
    })
    password:string

    @Column({
        type: 'boolean',
        default: true,
    })
    status: boolean

    @OneToOne(
        type => UserDetails,
        {
            cascade: true,
            nullable: false,
            eager: true
        }
    )
    @JoinColumn({
        name: 'detail_id'
    })
    details: UserDetails

    @ManyToMany(type => Role, role => role.users)
    @JoinTable({
        name: 'user_role'
    })
    roles: Role[]

    @Column({
        type:'timestamp',
        name: 'created_at',
    })
    createdAt: Date

    @Column({
        type:'timestamp',
        name: 'updated_at',
    })
    updatedAt: Date
}