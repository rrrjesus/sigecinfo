<?php

use Phinx\Db\Adapter\MysqlAdapter;

class SigecinfoInicial extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('report_access', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8',
                'collation' => 'utf8_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('users', 'integer', [
                'null' => false,
                'default' => '1',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('views', 'integer', [
                'null' => false,
                'default' => '1',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'users',
            ])
            ->addColumn('pages', 'integer', [
                'null' => false,
                'default' => '1',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'views',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'pages',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'created_at',
            ])
            ->create();
        $this->table('report_online', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8',
                'collation' => 'utf8_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('user', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'id',
            ])
            ->addColumn('ip', 'string', [
                'null' => false,
                'default' => '',
                'limit' => 50,
                'collation' => 'utf8_general_ci',
                'encoding' => 'utf8',
                'after' => 'user',
            ])
            ->addColumn('url', 'string', [
                'null' => false,
                'default' => '',
                'limit' => 255,
                'collation' => 'utf8_general_ci',
                'encoding' => 'utf8',
                'after' => 'ip',
            ])
            ->addColumn('agent', 'string', [
                'null' => false,
                'default' => '',
                'limit' => 255,
                'collation' => 'utf8_general_ci',
                'encoding' => 'utf8',
                'after' => 'url',
            ])
            ->addColumn('pages', 'integer', [
                'null' => false,
                'default' => '1',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'agent',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'pages',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'created_at',
            ])
            ->addIndex(['user'], [
                'name' => 'fk_report_online_user',
                'unique' => false,
            ])
            ->create();
        $this->table('churchs', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('country_id', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 2,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('code_id', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'country_id',
            ])
            ->addColumn('church_name', 'string', [
                'null' => false,
                'limit' => 150,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'code_id',
            ])
            ->addColumn('phone', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'church_name',
            ])
            ->addColumn('photo', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'phone',
            ])
            ->addColumn('address', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'photo',
            ])
            ->addColumn('address_number', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'address',
            ])
            ->addColumn('zip_code', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 9,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'address_number',
            ])
            ->addColumn('city', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'zip_code',
            ])
            ->addColumn('state', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'city',
            ])
            ->addColumn('observations', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'state',
            ])
            ->addColumn('status', 'string', [
                'null' => false,
                'default' => 'actived',
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'observations',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'status',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('login_created', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'updated_at',
            ])
            ->addColumn('login_updated', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'login_created',
            ])
            ->addIndex(['login_created'], [
                'name' => 'fk_churches_created_by',
                'unique' => false,
            ])
            ->addIndex(['login_updated'], [
                'name' => 'fk_churches_updated_by',
                'unique' => false,
            ])
            ->create();
        $this->table('events', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('title', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('description', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'title',
            ])
            ->addColumn('start_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'description',
            ])
            ->addColumn('end_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'start_at',
            ])
            ->addColumn('church_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'end_at',
            ])
            ->addColumn('type_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'church_id',
            ])
            ->addColumn('location_text', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'type_id',
            ])
            ->addColumn('meeting_url', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'location_text',
            ])
            ->addColumn('status', 'string', [
                'null' => false,
                'default' => 'agendado',
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'comment' => 'Valores possíveis: agendado, ao vivo, realizado, cancelado',
                'after' => 'meeting_url',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => true,
                'default' => 'current_timestamp()',
                'after' => 'status',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('created_by', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'updated_at',
            ])
            ->addColumn('updated_by', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'created_by',
            ])
            ->addColumn('google_calendar_event_id', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'updated_by',
            ])
            ->addIndex(['church_id'], [
                'name' => 'fk_events_church_id',
                'unique' => false,
            ])
            ->addIndex(['type_id'], [
                'name' => 'fk_events_type_id',
                'unique' => false,
            ])
            ->addIndex(['created_by'], [
                'name' => 'fk_events_created_by',
                'unique' => false,
            ])
            ->addIndex(['updated_by'], [
                'name' => 'fk_events_updated_by',
                'unique' => false,
            ])
            ->create();
        $this->table('event_participants', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('event_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'id',
            ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'event_id',
            ])
            ->addColumn('status', 'string', [
                'null' => false,
                'default' => 'convocado',
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'comment' => 'convocado, confirmado, justificado, presente',
                'after' => 'user_id',
            ])
            ->addColumn('signature', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'status',
            ])
            ->addColumn('justification', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'signature',
            ])
            ->addColumn('checkin_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'justification',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'checkin_at',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('login_created', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'updated_at',
            ])
            ->addColumn('login_updated', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'login_created',
            ])
            ->addIndex(['event_id'], [
                'name' => 'fk_event_participants_event',
                'unique' => false,
            ])
            ->addIndex(['user_id'], [
                'name' => 'fk_event_participants_user',
                'unique' => false,
            ])
            ->addIndex(['login_created'], [
                'name' => 'fk_event_participants_created_by',
                'unique' => false,
            ])
            ->addIndex(['login_updated'], [
                'name' => 'fk_event_participants_updated_by',
                'unique' => false,
            ])
            ->create();
        $this->table('event_types', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('description', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('status', 'string', [
                'null' => false,
                'default' => 'actived',
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'description',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'status',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('created_by', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'updated_at',
            ])
            ->addColumn('updated_by', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'created_by',
            ])
            ->addIndex(['created_by'], [
                'name' => 'fk_event_types_created_by',
                'unique' => false,
            ])
            ->addIndex(['updated_by'], [
                'name' => 'fk_event_types_updated_by',
                'unique' => false,
            ])
            ->create();
        $this->table('google_auth_tokens', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'id',
            ])
            ->addColumn('access_token', 'text', [
                'null' => false,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'user_id',
            ])
            ->addColumn('refresh_token', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'access_token',
            ])
            ->addColumn('expires_in', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'refresh_token',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'expires_in',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'created_at',
            ])
            ->addIndex(['user_id'], [
                'name' => 'uniq_user_id',
                'unique' => true,
            ])
            ->create();
        $this->table('levels', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('level_name', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('description', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'level_name',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'description',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('login_created', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'updated_at',
            ])
            ->addColumn('login_updated', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'login_created',
            ])
            ->addIndex(['login_created'], [
                'name' => 'fk_levels_created_by',
                'unique' => false,
            ])
            ->addIndex(['login_updated'], [
                'name' => 'fk_levels_updated_by',
                'unique' => false,
            ])
            ->create();
        $this->table('report_pages', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('url', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('accesses', 'integer', [
                'null' => false,
                'default' => '1',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'url',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'accesses',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'created_at',
            ])
            ->create();
        $this->table('users', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('user_name', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('email', 'string', [
                'null' => false,
                'limit' => 150,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'user_name',
            ])
            ->addColumn('photo', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'email',
            ])
            ->addColumn('phone_landline', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'photo',
            ])
            ->addColumn('phone_mobile', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'phone_landline',
            ])
            ->addColumn('password', 'string', [
                'null' => false,
                'default' => '$2y$10$nRtJo2JSTuiSNVHENwObzuqHmR4ZTd6ojDzHM.Ex874o8WfcI225i',
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'phone_mobile',
            ])
            ->addColumn('forget', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'password',
            ])
            ->addColumn('status', 'string', [
                'null' => true,
                'default' => 'registered',
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'comment' => 'registered, confirmed, trash',
                'after' => 'forget',
            ])
            ->addColumn('level_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'status',
            ])
            ->addColumn('position_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'level_id',
            ])
            ->addColumn('church_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'position_id',
            ])
            ->addColumn('observations', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'church_id',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'observations',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('login_created', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'updated_at',
            ])
            ->addColumn('login_updated', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'login_created',
            ])
            ->addColumn('bio', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'login_updated',
            ])
            ->addIndex(['email'], [
                'name' => 'email',
                'unique' => true,
            ])
            ->addIndex(['level_id'], [
                'name' => 'fk_users_level',
                'unique' => false,
            ])
            ->addIndex(['position_id'], [
                'name' => 'fk_users_position',
                'unique' => false,
            ])
            ->addIndex(['church_id'], [
                'name' => 'fk_users_church',
                'unique' => false,
            ])
            ->addIndex(['login_created'], [
                'name' => 'fk_users_created_by',
                'unique' => false,
            ])
            ->addIndex(['login_updated'], [
                'name' => 'fk_users_updated_by',
                'unique' => false,
            ])
            ->create();
        $this->table('user_positions', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('position_name', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('description', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'position_name',
            ])
            ->addColumn('status', 'string', [
                'null' => false,
                'default' => 'actived',
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'comment' => 'registered, confirmed, trash',
                'after' => 'description',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => false,
                'default' => 'current_timestamp()',
                'after' => 'status',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('login_created', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'updated_at',
            ])
            ->addColumn('login_updated', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'after' => 'login_created',
            ])
            ->addIndex(['login_created'], [
                'name' => 'fk_positions_created_by',
                'unique' => false,
            ])
            ->addIndex(['login_updated'], [
                'name' => 'fk_positions_updated_by',
                'unique' => false,
            ])
            ->create();
    }
}
