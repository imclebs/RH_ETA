Sistema RH - ETA Engenharia

O Sistema RH - ETA Engenharia é uma aplicação web desenvolvida para a gestão de colaboradores, documentos e relatórios do setor de Recursos Humanos da empresa ETA Engenharia.
Criado com PHP e MySQL, o sistema é simples de implantar em servidores como a HostGator, mantendo desempenho, segurança e flexibilidade.

Objetivo

O sistema foi projetado para centralizar as informações de colaboradores e otimizar processos de RH, oferecendo:

Cadastro completo de colaboradores

Armazenamento e gerenciamento de documentos por colaborador

Controle de status (ativo ou desligado)

Relatórios filtráveis e exportação em CSV

Painel administrativo com estatísticas e gráficos

Principais Funcionalidades
Cadastro de Colaboradores

Inclusão, edição e exclusão de colaboradores.

Campos configuráveis como nome, função, cidade, polo e status.

Matrícula gerada automaticamente seguindo um padrão anual.

Gerenciamento de Documentos

Upload de qualquer tipo de arquivo (PDF, imagens, planilhas, etc.).

Armazenamento organizado em pastas individuais por colaborador.

Histórico de uploads com opções para editar e excluir.

Painel de Controle (Dashboard)

Visão geral do sistema em tempo real.

Gráficos de colaboradores ativos vs desligados.

Total de documentos cadastrados.

Listagem dos últimos uploads.

Relatórios

Filtros por status, cidade, polo e período.

Exportação de relatórios em formato CSV.

Visualização direta dos resultados na interface.

Estrutura de Pastas
/config
    db_connect.php
/actions
    login.php
    add_colaborador.php
    delete_colaborador.php
    export_report.php
/pages
    login.php
    dashboard.php
    colaboradores.php
    reports.php
/Documentos
    /MATRICULA+NOME/
/assets
    /css
    /js
sistema_rh_eta.sql

Banco de Dados

O sistema utiliza um banco de dados MySQL com as tabelas principais:

usuarios – controle de acesso e níveis de permissão.

colaboradores – informações pessoais e funcionais.

documentos – histórico e arquivos vinculados a cada colaborador.

Para importar o banco:

Acesse o phpMyAdmin do seu servidor.

Crie um banco de dados.

Importe o arquivo sistema_rh_eta.sql.

Configuração

Atualize o arquivo config/db_connect.php com as credenciais do seu banco de dados.

Envie todos os arquivos para o servidor (pasta public_html ou raiz do projeto).

Ajuste as permissões da pasta Documentos para permitir upload.

Acesse o sistema pelo navegador para iniciar o uso.

Tecnologias Utilizadas

PHP 8+

MySQL

Bootstrap 5

Chart.js

HTML5 / CSS3 / JavaScript

Design

O layout segue a identidade visual da ETA Engenharia, com as seguintes cores predominantes:

Azul-marinho #25499B

Verde-musgo #556049

Azul-claro #B4C6DC

Cinza-claro #E6E9F1

Licença

Este projeto é de uso interno da ETA Engenharia.
A reprodução, distribuição ou modificação sem autorização prévia não é permitida.
