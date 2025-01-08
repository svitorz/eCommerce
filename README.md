# Projeto de E-commerce

Este projeto é uma aplicação de e-commerce desenvolvida para fornecer uma plataforma completa de compras online. Construída com o framework Laravel juntamente com Vuejs, a aplicação oferece uma variedade de funcionalidades essenciais para operações de comércio eletrônico.

## Funcionalidades

- **Catálogo de Produtos**: Exibição de produtos com detalhes como nome, descrição, preço e imagens.
- **Carrinho de Compras**: Permite que os usuários adicionem produtos ao carrinho e gerenciem as quantidades desejadas.
- **Processamento de Pedidos**: Fluxo completo de checkout, incluindo cálculo de frete e impostos.
- **Autenticação de Usuários**: Registro e login de clientes para gerenciar informações pessoais e históricos de pedidos.
- **Painel Administrativo**: Interface para gerenciamento de produtos, categorias, pedidos e usuários.

## Tecnologias Utilizadas

- **Backend**: Laravel (PHP)
- **Frontend**: VueJS, Tailwind CSS
- **Banco de Dados**: POSTGRESQL 
- **Controle de Versão**: Git
- **Containerização**: Docker

## Técnicas de Programação

- **Arquitetura MVC**: Separação clara entre Modelos, Visões e Controladores para facilitar a manutenção e escalabilidade.
- **Migrações de Banco de Dados**: Uso de migrações para versionamento e controle do esquema do banco de dados.
- **Validação de Dados**: Implementação de validações robustas para entradas de usuários, garantindo integridade e segurança.
- **Autenticação e Autorização**: Sistemas implementados para controlar o acesso a diferentes partes da aplicação.
- **Testes Automatizados**: Utilização de Pest para garantir a qualidade e funcionalidade do código.

## Instalação

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/svitorz/ecommerce.git
   cd ecommerce
   ```
2. **Instale as dependências**:
   ```bash
   sail composer install
   sail npm install
   ```
3. **Configure o ambiente**:
   - Duplique o arquivo `.env.example` e renomeie para `.env`.
   - Configure as variáveis de ambiente, incluindo detalhes do banco de dados.
4. **Gere a chave da aplicação**:
   ```bash
   sail php artisan key:generate
   ```
5. **Execute as migrações e seeders**:
   ```bash
   sail php artisan migrate --seed
   ```
6. **Inicie o servidor de desenvolvimento**:
   ```bash
   sail up -d
   ```

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e enviar pull requests.

## Licença

Este projeto está licenciado sob a licença MIT. Consulte o arquivo [LICENSE](https://github.com/svitorz/ecommerce/blob/master/LICENSE) para mais detalhes. 
