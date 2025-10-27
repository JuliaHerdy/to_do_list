create table tasks
(
    id   SERIAL primary key,
    task_title text not null,
    task_description text not null,
    start_date date not null default CURRENT_DATE,
    deadline date not null,
    status int not null default 0
);

insert into tasks (task_title, task_description, deadline)
values ('Atividade de português', 'Professora Vilma', '2025-11-10'),
       ('Atividade de matemática', 'Professor Alberto', '2025-11-25'),
       ('Trabalho final de Inglês', 'Fazer um slide sobre o tema', '2025-12-01'),
       ('Aula de natação', 'Rua Niteroi, nº 112 ás 10h', '2025-11-01'),
       ('Consulta médica', 'Lembrar de levar o resultado do exame de sangue', '2025-10-30');

update tasks set status = 1 where id = 2;
update tasks set status = 1 where id = 3;
