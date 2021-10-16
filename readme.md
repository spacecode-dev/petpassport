# Start a project
```sh
    git clone git@github.com:ioann7878/PETPASSPORT.git
    composer install
    php artisan passport:install
    php artisan storage:link
    npm install
    npm run dev

    php artisan serve
```
Configuring Postgresql full-text search

1.Download dictionaries (e.g. Russian and English):
```sh
    http://arendar.info/img/common/content/psql_dict.zip
```

2. Move content to folder:
```sh
    /usr/share/postgresql/12/tsearch_data
```

2. Move content to folder:
```sh
    /usr/share/postgresql/12/tsearch_data
```

3.Execute two queries:
```sh
    CREATE TEXT SEARCH DICTIONARY russian_ispell (
        TEMPLATE = ispell,
        DictFile = russian,
        AffFile = russian,
        StopWords = russian
    );
    
    CREATE TEXT SEARCH DICTIONARY english_ispell (
        TEMPLATE = ispell,
        DictFile = english,
        AffFile = english,
        StopWords = english
    )
```

3.Check dictionary:

```sh
    SELECT * FROM ts_lexize('russian_ispell', 'поиск');
     ts_lexize 
    -----------
     {поиск}
    (1 row)
```

4.Now we need to create our own configuration that we can use in the future:

```sh
    CREATE TEXT SEARCH CONFIGURATION ru_config ( COPY = russian );
```


5.Now you need to configure the dictionary for configuration:

```sh
    ALTER TEXT SEARCH CONFIGURATION ru_config
        ALTER MAPPING
            FOR word, hword, hword_part
            WITH russian_ispell, russian_stem;
    
    
    ALTER TEXT SEARCH CONFIGURATION ru_config
        ALTER MAPPING
            FOR asciiword, asciihword, hword_asciipart
            WITH english_ispell, english_stem;
```

5)You can view this configuration by executing \ dF + ru_config in the terminal,
 we will get a table of configuration tokens and dictionaries that are used for it, 
more details about tokens can be found on the documentation page. Here is the result:

```sh
    Text search configuration "public.ru_config"
    Parser: "pg_catalog.default"
          Token      |        Dictionaries         
    -----------------+-----------------------------
     asciihword      | english_ispell,english_stem
     asciiword       | english_ispell,english_stem
     email           | simple
     file            | simple
     float           | simple
     host            | simple
     hword           | russian_ispell,russian_stem
     hword_asciipart | english_ispell,english_stem
     hword_numpart   | simple
     hword_part      | russian_ispell,russian_stem
     int             | simple
     numhword        | simple
     numword         | simple
     sfloat          | simple
     uint            | simple
     url             | simple
     url_path        | simple
     version         | simple
     word            | russian_ispell,russian_stem
    :
```

6)Now you can use it. Set it by default:

```sh
    SET default_text_search_config = 'ru_config';
```

7)Check the configuration:

```sh
    SELECT * FROM ts_debug('ru_config', 'Search. Поиск. 152');
```

8)If everyone should get a similar table correctly:
```sh
       alias   |    description    | token  |       dictionaries       | dictionary | lexemes  
    -----------+-------------------+--------+--------------------------+------------+----------
     asciiword | Word, all ASCII   | Search | {ispell_en,english_stem} | ispell_en  | {search}
     blank     | Space symbols     | .      | {}                       |            | 
     word      | Word, all letters | Поиск  | {ispell_ru,russian_stem} | ispell_ru  | {поиск}
     blank     | Space symbols     | .      | {}                       |            | 
     uint      | Unsigned integer  | 152    | {simple}                 | simple     | {152}
    (5 rows)
```

Verify the deployment by navigating to your server address in your preferred browser.

```sh
    127.0.0.1:8000
```
