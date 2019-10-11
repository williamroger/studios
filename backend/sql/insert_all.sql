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

---------------------------------------------%-------------------------------------------

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

///////////////////////---------------------------------------------%-------------------------------------------
INSERT INTO time_periods
(price, room_id, day, begin_period, end_period)
VALUES
('60.00', 1, 'Monday', '08:00:00', '11:00:00');