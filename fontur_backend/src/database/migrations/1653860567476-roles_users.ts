import {MigrationInterface, QueryRunner} from "typeorm";

export class rolesUsers1653860567476 implements MigrationInterface {
    name = 'rolesUsers1653860567476'

    public async up(queryRunner: QueryRunner): Promise<void> {
        await queryRunner.query(`CREATE TABLE "user_details" ("id" SERIAL NOT NULL, "nombres" character varying NOT NULL, "apellidos" character varying NOT NULL, "telefono" character varying NOT NULL, "created_at" TIMESTAMP NOT NULL, "updated_at" TIMESTAMP NOT NULL, CONSTRAINT "UQ_779c6b6d60c62bd0dc823902ead" UNIQUE ("nombres"), CONSTRAINT "UQ_920fe9db24ad0c36e258a87d676" UNIQUE ("apellidos"), CONSTRAINT "PK_fb08394d3f499b9e441cab9ca51" PRIMARY KEY ("id"))`);
        await queryRunner.query(`CREATE TABLE "roles" ("id" SERIAL NOT NULL, "name" character varying NOT NULL, "description" character varying NOT NULL, "status" boolean NOT NULL DEFAULT true, "created_at" TIMESTAMP NOT NULL, "updated_at" TIMESTAMP NOT NULL, CONSTRAINT "PK_c1433d71a4838793a49dcad46ab" PRIMARY KEY ("id"))`);
        await queryRunner.query(`CREATE TABLE "user_role" ("usersId" integer NOT NULL, "rolesId" integer NOT NULL, CONSTRAINT "PK_80c0fdeadb39af251fead9a275f" PRIMARY KEY ("usersId", "rolesId"))`);
        await queryRunner.query(`CREATE INDEX "IDX_0d65428bf51c2ce567216427d4" ON "user_role" ("usersId") `);
        await queryRunner.query(`CREATE INDEX "IDX_5d19ca4692b21d67f692bb837d" ON "user_role" ("rolesId") `);
        await queryRunner.query(`ALTER TABLE "user_role" ADD CONSTRAINT "FK_0d65428bf51c2ce567216427d46" FOREIGN KEY ("usersId") REFERENCES "users"("id") ON DELETE CASCADE ON UPDATE CASCADE`);
        await queryRunner.query(`ALTER TABLE "user_role" ADD CONSTRAINT "FK_5d19ca4692b21d67f692bb837df" FOREIGN KEY ("rolesId") REFERENCES "roles"("id") ON DELETE NO ACTION ON UPDATE NO ACTION`);
    }

    public async down(queryRunner: QueryRunner): Promise<void> {
        await queryRunner.query(`ALTER TABLE "user_role" DROP CONSTRAINT "FK_5d19ca4692b21d67f692bb837df"`);
        await queryRunner.query(`ALTER TABLE "user_role" DROP CONSTRAINT "FK_0d65428bf51c2ce567216427d46"`);
        await queryRunner.query(`DROP INDEX "public"."IDX_5d19ca4692b21d67f692bb837d"`);
        await queryRunner.query(`DROP INDEX "public"."IDX_0d65428bf51c2ce567216427d4"`);
        await queryRunner.query(`DROP TABLE "user_role"`);
        await queryRunner.query(`DROP TABLE "roles"`);
        await queryRunner.query(`DROP TABLE "user_details"`);
    }

}
