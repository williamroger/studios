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

---------------------------------------------%-------------------------------------------

INSERT INTO studios
(name, address, phone, description, cnpj, telephone, created_at, has_parking, is_24_hours, city_id)
VALUES
('Estúdio Recife 001',
'Rua Rosa e Silva, 353',
'81 99876-5434',
'Ótimo Estúdio para realizar ensaios',
'23.165.959/0001-82',
'81 3304-2430',
NOW(),
1,
0,
1
);

SELECT * FROM studios;

---------------------------------------------%-------------------------------------------

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

SELECT * FROM users;

---------------------------------------------%-------------------------------------------

INSERT INTO customers
	(name, phone, created_at, cpf, cities_id)
VALUES
 ('William',
  '81-2222-1111',
   now(),
  '111-222-111-11',
   1 
);

---------------------------------------------%-------------------------------------------

INSERT INTO users
	(email, password, created_at, customer_id, is_customer)
VALUES
	('william@gmail.com',
    '1010',
    now(),
    1,
    1
);