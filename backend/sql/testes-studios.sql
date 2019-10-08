INSERT INTO states
(initials, name)
VALUES
('AC', 'Acre'),
('AL', 'Alagoas '),
('AP', 'Amapá'),
('AM', 'Amazonas'),
('BA', 'Bahia'),
('CE', 'Ceará'),
('DF', 'Distrito Federal'),
('ES', 'Espírito Santo'),
('GO', 'Goiás'),
('MA', 'Maranhão'),
('MT', 'Mato Grosso'),
('MS', 'Mato Grosso do Sul'),
('MG', 'Minas Gerais'),
('PA', 'Pará'),
('PB', 'Paraíba'),
('PR', 'Paraná'),
('PE', 'Pernambuco'),
('PI', 'Piauí'),
('RJ', 'Rio de Janeiro'),
('RN', 'Rio Grande do Norte'),
('RS', 'Rio Grande do Sul'),
('RO', 'Rondônia'),
('RR', 'Roraima'),
('SC', 'Santa Catarina'),
('SP', 'São Paulo'),
('SE', 'Sergipe'),
('TO', 'Tocantins');

SELECT * FROM states;

INSERT INTO cities
(name, state_id)
VALUES
('Recife', 17),
('Jaboatão dos Guararapes', 17),
('Olinda', 17),
('Caruaru', 17),
('Petrolina', 17),
('Paulista', 17),
('Cabo de Santo Agostinho', 17),
('Camaragibe', 17),
('Garanhuns', 17),
('Vitória de Santo Antão', 17),
('Igarassu', 17),
('São Lourenço da Mata', 17),
('Abreu e Lima', 17),
('Ipojuca', 17);

SELECT * FROM cities;


INSERT INTO users 
	(email, password, created_at, studio_id, is_studio)
VALUES 
	(
     'estudiorecife001@studios.com.br', 
     'recife001', 
     NOW(), 
     1, 
     1
	);
    
SELECT * FROM studios WHERE name = 'Estúdio Recife 002';
    
SELECT * FROM customers;

UPDATE users SET email = "testandoupdate@gmail.com" WHERE studio_id = 1;

SELECT * FROM rooms;

SELECT * FROM rooms
INNER JOIN studios
ON rooms.studio_id = studios.id
WHERE studios.id = 11;

SELECT
	id,
    state_id,
    name
FROM cities
WHERE state_id = 17;

SELECT 
	cnpj
FROM studios
	WHERE cnpj = '73.373.517/0001-08' AND id != 6;
    
/* TIMES_PERIODS */

SELECT * FROM users;

INSERT INTO time_periods
	(price, room_id, day, begin_period, end_period)
VALUES
	('60.00', 1, 'Monday', '08:00:00', '11:00:00');
    
SELECT * FROM users;
/* Lista todos os períodos de uma sala */
SELECT 
	id,
	amount,
	room_id,
	day,
    day_order,
	price_rate,
	begin_period,
	end_period,
	created_at,
	updated_at
FROM time_periods
WHERE room_id = 1
ORDER BY day_order;

/* AGENDAMENTO */

INSERT INTO schedules
	(date_scheduling,
     status,
     created_at,
     customer_id,
     comment)
VALUE ('2019-10-07',
	    0,
        now(),
        5,
        'Prefiro que o ar-condicionado esteja desligado.');

INSERT INTO schedules_time_periods
	(schedule_id,
     time_period_id)
VALUES
	(1, 12);


SELECT 
  id,
  date_scheduling,
  status,
  date_cancellation,
  created_at,
  updated_at,
  customer_id,
  comment
FROM schedules;
    
SELECT * FROM schedules_time_periods;

/* Listar todos os agendamentos para o estúdio */
SELECT * FROM schedules_time_periods
INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
INNER JOIN rooms ON time_periods.room_id = rooms.id
WHERE rooms.studio_id = 1;

/* Listar todos os agendamentos para o estúdio pela data */
SELECT * FROM schedules_time_periods
INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
INNER JOIN rooms ON time_periods.room_id = rooms.id
WHERE rooms.studio_id = 1 AND schedules.date_scheduling = "2019-10-08";

/* Listar todos os agendamentos feitos pelo usuário */
SELECT * FROM schedules_time_periods
INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
INNER JOIN rooms ON time_periods.room_id = rooms.id
WHERE schedules.customer_id = 1;

/* Listar todos os períodos de uma sala por dia da semana */
SELECT * FROM time_periods
WHERE time_periods.room_id = 1 AND time_periods.day = "Monday" 
ORDER BY day_order;

/* Listar todos os períodos de uma sala que não estejam ocupado por data '2019-10-08' */
SELECT * FROM time_periods
WHERE  time_periods.room_id = 2 
AND time_periods.day = "Monday" 
AND time_periods.id NOT IN (
												    SELECT schedules_time_periods.time_period_id FROM schedules_time_periods
											      INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
												    LEFT JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id AND time_periods.room_id = 2
												    WHERE schedules.date_scheduling = "2019-10-08"
                            )
ORDER BY day_order;


SELECT * FROM schedules_time_periods
INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
WHERE schedules.date_scheduling = "2019-10-08";

    
    
    
    
    
    
    
    
/* Updates */
ALTER TABLE `db_dev_studios`.`schedules_time_periods`
DROP FOREIGN KEY `fk_Agendamentos_has_Horarios_Horarios1`,
DROP FOREIGN KEY `fk_Agendamentos_has_Horarios_Agendamentos`;
ALTER TABLE `db_dev_studios`.`schedules_time_periods`
DROP INDEX `fk_Agendamentos_has_Horarios_Agendamentos_idx` ,
DROP INDEX `fk_Agendamentos_has_Horarios_Horarios1_idx` ;

ALTER TABLE `db_dev_studios`.`time_periods`
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db_dev_studios`.`time_periods`
CHANGE COLUMN `price` `amount` DECIMAL(10,2) NOT NULL ;

