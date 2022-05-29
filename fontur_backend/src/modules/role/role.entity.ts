import { BaseEntity, Column, Entity, JoinColumn, JoinTable, ManyToMany, PrimaryGeneratedColumn } from "typeorm";
import { User } from "../user/user.entity";

@Entity('roles')
export class Role extends BaseEntity{
    
    @PrimaryGeneratedColumn('increment')
    id: number

    @Column({
        type: 'varchar',
        nullable: false
    })
    name: string

    @Column({
        type: 'varchar',
        nullable: false
    })
    description: string

    @ManyToMany(type => User, user => user.roles)
    @JoinColumn()
    users: User[]

    @Column({
        type: 'boolean',
        default: true,
    })
    status: boolean

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