# Playmobile Challenge



## REACT NODE v18

Entre na pasta 'frontend-challenge' #
Dentro da pasta execute 'npm install' #
Depois execute 'npm run build' para setar as variáveis de ambiente #
Para iniciar execute 'npm start' #


## LARAVEL v10



Entre na pasta 'playmobile-challenge' #
Dentro da pasta execute 'composer install' #
Faça uma cópia do '.env' e renomeie o '.env.example' para '.env' #
Configure as variáveis de ambiente de acordo com o seu banco; #
Em 'QUEUE_CONNECTION' coloque 'database' #
Execute 'php artisan key:generate' #
Depois execute 'php artisan migrate' #
Depois execute 'php artisan serve' #
Abra outro terminal e execute 'php artisan queue:work' #
Para iniciar a raspagem de dados acesse a rota 'http://127.0.0.1:8000/iniciar-rapasgem?sp=700&qt=10'; #

# Parâmetros: 'sp' é posição inicial da fonte << as páginas do finep tem um 'ID' e as páginas começam do 294 e vai até o 716;
# Parâmetros: 'qt' é a quantidade de registros que você deseja buscar;
# Parâmetros: o valor padrão de 'sp' é 700 e de 'qt' é 10

Para acessar a listagem do conteúdo 'http://localhost:3000/'
