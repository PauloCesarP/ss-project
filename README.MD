ss-project

Um tema WordPress iniciado com TailPress e Tailwind CSS, pronto para desenvolvimento de sites rápidos e modernos usando as ferramentas modernas de frontend.

🧠 Visão geral

Este projeto é um tema WordPress personalizado, baseado no framework TailPress, que combina a estrutura do WordPress com o utilitário de estilos do Tailwind CSS para facilitar o desenvolvimento de layouts responsivos e flexíveis.

🚀 Funcionalidades principais

Estrutura de tema WordPress completa (templates de página, cabeçalho, rodapé, etc.)

Suporte integrado para estilos com Tailwind CSS

Páginas padrões já definidas como:

front-page.php

page-about.php

page-contact.php

page-services.php

page-projects.php

Organização de arquivos em pastas como:

inc/ para funções PHP reutilizáveis

src/ para scripts e estilos front-end

template-parts/ para partes de layout reutilizáveis

Arquivos de configuração para build com ferramentas modernas

🛠️ Instalação

Clone o repositório:

git clone https://github.com/PauloCesarP/ss-project.git

Copie para sua pasta de temas do WordPress (wp-content/themes/ss-project).

Instale dependências (caso use npm/yarn):

npm install
# ou
yarn install

Compile os assets:

npm run dev
# ou
yarn dev

Ative o tema no painel do WordPress (Aparência → Temas).

📦 Estrutura do projeto
ss-project/
├── inc/                  # Funções PHP auxiliares
├── resources/            # Scripts, estilos e assets
├── src/                  # Fonte para build com Tailwind/Vite
├── template-parts/       # Partes do tema (header, footer, etc.)
├── page-*.php            # Templates de páginas específicas
├── style.css             # Arquivo base do tema
├── theme.json            # Configurações do tema WordPress
├── vite.config.mjs       # Configuração do build (Vite)
└── README.MD             # Este arquivo
🧩 Requisitos

Para desenvolvimento e uso:

WordPress instalado (>= última versão)

Node.js (para compilar assets com Tailwind/Vite)

Servidor local ou ambiente de produção com PHP e banco de dados

📜 Licença

Este projeto está licenciado sob a MIT License — veja o arquivo LICENSE para mais detalhes.
