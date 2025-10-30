# SIGECINFO

![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white&style=flat)
![Arquitetura](https://img.shields.io/badge/Arquitetura-MVC-blue?style=flat)
![API](https://img.shields.io/badge/API-REST-green?style=flat)
![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)
![Status](https://img.shields.io/badge/Status-Em%20Desenvolvimento-orange)
![Versão](https://img.shields.io/badge/Versão-1.0.0-lightgrey)

---

## 📖 Sobre o Projeto

**SIGECINFO (Sistema de Gerenciamento e Controle de Informações)** é uma aplicação web robusta, construída em **PHP 8.2+** com uma arquitetura **MVC (Model-View-Controller)**. O sistema foi projetado para oferecer uma solução completa para o gerenciamento e controle de pessoas, eventos e reuniões, fornecendo agilidade, segurança e centralização de dados.

O projeto inclui uma **API REST** para integração com outras aplicações, como sistemas mobile, e utiliza as melhores práticas de desenvolvimento para garantir um código limpo, organizado e de fácil manutenção.

---

## 🚀 Funcionalidades Principais

- **Gestão de Eventos:** Cadastro e gerenciamento completo de eventos e reuniões.
- **Controle de Acesso:** Controle de portaria e acessos com identificação via QR Code.
- **Relatórios Detalhados:** Geração de relatórios de participantes, frequência e outros dados relevantes.
- **Lista de Chamada:** Funcionalidade de lista de chamada automática para eventos.
- **API RESTful:** Exposição de dados de forma segura para consumo por outras aplicações.
- **Autenticação Social:** Login com Google (OAuth 2.0).
- **Envio de E-mails:** Integração com PHPMailer e SendGrid para notificações.

---

## 🛠️ Tecnologias Utilizadas

O projeto foi construído com as seguintes tecnologias e bibliotecas:

- **Backend:**
  - **PHP 8.2+**
  - **Arquitetura:** MVC (Model-View-Controller)
  - **Roteamento:** `coffeecode/router`
  - **Templates:** `league/plates`
  - **Banco de Dados:** Interação via PDO (pronto para MySQL, PostgreSQL, etc.)
- **Frontend:**
  - **Bootstrap 5.3**
  - **JavaScript**
  - **Minificação de Assets:** `matthiasmullie/minify`
- **Gerenciamento de Mídia:**
  - **Uploads:** `coffeecode/uploader`
  - **Manipulação de Imagens:** `coffeecode/cropper`
- **Comunicação e APIs:**
  - **Envio de E-mail:** `phpmailer/phpmailer` e `sendgrid/sendgrid`
  - **Autenticação:** `league/oauth2-google`
- **Utilitários:**
  - **Paginação:** `coffeecode/paginator`
  - **Otimização (SEO):** `coffeecode/optimizer`

---

## ⚙️ Instalação e Uso

Siga os passos abaixo para configurar o ambiente de desenvolvimento local.

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/rrrjesus/sigecinfo.git
    cd sigecinfo
    ```

2.  **Instale as dependências:**
    Certifique-se de ter o [Composer](https://getcomposer.org/) instalado e execute o comando:
    ```bash
    composer install
    ```

3.  **Configure o Ambiente:**
    - Renomeie o arquivo `.env.example` para `.env`.
    - Abra o arquivo `.env` e configure as variáveis de ambiente, incluindo as credenciais do banco de dados e chaves de API (Google, SendGrid, etc.).

4.  **Servidor Web:**
    - Configure um servidor web local (Apache, Nginx) para apontar para a raiz do projeto.
    - Certifique-se de que o `mod_rewrite` (para Apache) esteja ativado para o roteamento funcionar corretamente.

---

## 📂 Estrutura do Projeto

A estrutura de pastas principal do projeto é a seguinte:

```
/
├── source/         # Código-fonte da aplicação (MVC)
│   ├── App/        # Controladores
│   ├── Core/       # Núcleo do sistema (Model, View, Controller, etc.)
│   ├── Domain/     # Regras de negócio e modelos de domínio
│   └── Support/    # Classes de suporte (Email, Upload, etc.)
├── themes/         # Arquivos de visão (templates)
│   ├── admin/      # Tema da área administrativa
│   └── web/        # Tema do site público
├── vendor/         # Dependências do Composer
├── shared/         # Assets (CSS, JS, imagens)
└── .env            # Arquivo de configuração de ambiente
```

---

## 📄 Licença

Este projeto está licenciado sob a **Licença MIT**. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.