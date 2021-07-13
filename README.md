Pokedex YII2 API
================

## Instalation ##

### Step 1 ###

download the project, and open the folder. 

```SHELL
$ git clone https://github.com/RodrigoDornelles/pokedex-yii-api
$ cd pokedex-yii-api
```

### Step 2 ###

Install dependencies. _(after installation the database will be structured and inserted automatically.)_

```SHELL
$ composer install
```

### Step 3 ###

Run project! 

```SHELL
$ php yii serve
```


## Usage ##

Information provided by restful api.

| endpoint | description | params |
| :------: | :---------- | :----- |
| `/status` | api status | |
| `/list` | list pokemons filtered | `PokemonSearch[]`<br/>`sort` `page` `per-page` |
| `/info/id/<9>`<br/>`/info/number/<9>` | view pokemon info | (use id or number) |
