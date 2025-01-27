# Sistema de Gerenciamento Escolar

## Descrição do Projeto

O Sistema de Gerenciamento Escolar é uma aplicação web desenvolvida para facilitar a administração de informações relacionadas a escolas, incluindo gerenciamento de edifícios, salas, andares, recursos e usuários. O projeto adota a arquitetura MVC (Model-View-Controller), que separa a lógica de negócios, a interface do usuário e a manipulação de dados, proporcionando uma estrutura organizada e escalável.

## Estrutura de Pastas

A estrutura de pastas do projeto é a seguinte:

```
/api
├── .htaccess  
├── config
│ └── database.php
├── controllers
│ ├── building_controller.php
│ ├── class_controller.php
│ ├── color_controller.php
│ ├── floor_controller.php
│ ├── notification_controller.php
│ ├── resource_controller.php
│ ├── resource_reservation_controller.php
│ ├── room_controller.php
│ ├── room_reservation_controller.php
│ └── user_controller.php
├── models
│ ├── building.php
│ ├── class.php
│ ├── color.php
│ ├── floor.php
│ ├── notification.php
│ ├── resource.php
│ ├── resource_reservation.php
│ ├── room.php
│ ├── room_reservation.php
│ └── room_type.php
├── routes
│ ├── user_routes.php
│ ├── color_routes.php
│ ├── class_routes.php
│ ├── building_routes.php
│ ├── floor_routes.php
│ ├── room_routes.php
│ ├── resource_routes.php
│ ├── room_type_routes.php
│ ├── notification_routes.php
│ └── resource_reservation_routes.php
└── index.php
/public
├── assets
│ ├── css
│ │ ├── infrastructure.css
│ │ ├── styles.css
│ │ └── users.css
│ └── js
│ ├── infrastructure.js
│ ├── main.js
│ └── users.js
└── main.html
/database
└── school_management.sql
```

## Funcionamento da API

A API é responsável por gerenciar as requisições e respostas entre o cliente e o servidor. As principais funcionalidades incluem:

- **CRUD (Create, Read, Update, Delete)** para entidades como edifícios, salas, andares, recursos e usuários.
- **Gerenciamento de reservas** para salas e recursos.
- **Autenticação e autorização** de usuários.

### Requisições

As requisições são feitas através de métodos HTTP (GET, POST, PUT, DELETE) e são direcionadas para as rotas específicas definidas na pasta `routes`. Cada controlador na pasta `controllers` manipula as requisições e interage com os modelos na pasta `models` para realizar operações no banco de dados.

### Exemplos de Rotas

- `GET /api/buildings` - Retorna a lista de edifícios.
- `POST /api/buildings` - Cria um novo edifício.
- `PUT /api/buildings/{id}` - Atualiza um edifício existente.
- `DELETE /api/buildings/{id}` - Remove um edifício.

## Proposta do Projeto

A proposta do projeto é fornecer uma solução integrada para o gerenciamento de informações escolares, permitindo que administradores e usuários acessem e manipulem dados de forma eficiente. O sistema visa resolver problemas comuns enfrentados por instituições de ensino, como a falta de organização e a dificuldade em acessar informações relevantes.

## Metodologia Utilizada

O desenvolvimento do projeto seguiu a metodologia ágil, permitindo iterações rápidas e feedback contínuo. As principais etapas incluíram:

1. **Planejamento**: Definição dos requisitos e funcionalidades do sistema.
2. **Desenvolvimento**: Implementação das funcionalidades utilizando a arquitetura MVC.
3. **Testes**: Realização de testes para garantir a qualidade e a funcionalidade do sistema.
4. **Implantação**: Disponibilização do sistema para uso.

## Arquitetura Utilizada

A arquitetura MVC (Model-View-Controller) foi adotada para separar as responsabilidades do sistema:

- **Model**: Representa a lógica de dados e interage com o banco de dados.
- **View**: Responsável pela interface do usuário e apresentação dos dados.
- **Controller**: Manipula as requisições do usuário, interage com o modelo e retorna a resposta apropriada.

## Problema que o Projeto Deve Solucionar

O projeto visa solucionar a falta de um sistema eficiente para o gerenciamento de informações escolares, proporcionando uma interface amigável e funcionalidades robustas para a administração de dados. Com isso, espera-se melhorar a organização, a acessibilidade e a eficiência na gestão escolar.

---

## Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests para melhorias e correções.