import {BaseEntity, Column, Entity, PrimaryGeneratedColumn} from 'typeorm'

@Entity('user_details')
export class UserDetails extends BaseEntity{

    @PrimaryGeneratedColumn('increment')
    id: number

    @Column({
        type: 'varchar',
        unique: true,
        nullable: false
    })
    nombres:string

    @Column({
        type:'varchar',
        unique: true,
        nullable: false
    })
    apellidos:string

    @Column({
        type:'varchar',
        nullable: false
    })
    telefono:string

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