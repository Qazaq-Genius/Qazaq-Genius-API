# Qazaq Genius Lyrics API
This is the implementation of the lyrics api for the Qazaq Genius website.


## 👨‍💻 Technologies Used
* [Slim-Framework 4](https://www.slimframework.com/)
* [PHP 8.2](https://www.php.net/)
* [MySQL 8.0](https://www.mysql.com/)
* [Docker](https://www.docker.com/get-started)
* [Composer](https://getcomposer.org/)
* [OpenAPI](https://spec.openapis.org/oas/v3.1.0)
* [Swagger](https://swagger.io/)

## Developement
0. Have [Docker](https://www.docker.com/get-started) and Make installed
1. Clone repository
2. Build and start the project
    1. `cd` into the project folder
    2. `make build_dev` to build the docker images
    3. `make install` to install the dependencies
    4. `make start` to fire up the project
3. Open a new ticket (and in an ideal case a new feature-branch)
4. Write your code & tests
5. Please execute make `unit_test`, `make sniff` and `make sniffer_fix` before pushing your changes

## Deployment
There are currently 3 environments. 

* Intgeration: Gets deployed on every commit
* Staging: Gets deployed on every commit on master
* Live: Gets deployed ony by hand

## Documentation

Swagger documentation of the routes: https://swagger.r0.fyi/

### Database structure
```mermaid
---
title: Song Database
---
erDiagram
    Album {
        varchar     name_cyr
        varchar     name_lat
        varchar     cover_art
        datetime    release_date
        datetime	created
        datetime	modified
        int	        main_artist_id
        int	        id
    }
    AlbumArtists {
        int          album_id
        int          artist_id
        int          id
    }
    Artist {
        varchar      name_cyr
        varchar      name_lat
        datetime     created
        datetime     modified
        int          id
    }
    Lyrics {
        int			verse_nr
        int			line_nr
        varchar      qazaq_cyr
        varchar      qazaq_lat
        varchar      english
        varchar      russian
        text         original_lang
        datetime     created
        datetime     modfied
        int          song_id
        int	        id
    }
    Media {
        varchar     name
        varchar     url
        datetime	created
        datetime	modified
        int	        song_id
        int	        id
    }
    Song {
        varchar      title_cyr
        varchar      title_lat
        datetime     release_date
        datetime	    created
        datetime	    modified
        int	        main_artist_id
        int	        album_id
        int	        id
    }
    SongArtists {
        int          artist_id
        int          song_id
        int          id
    }
    Words {
        tinyint	    word_in_line_nr
        varchar      qazaq_cyr
        varchar      qazaq_lat
        varchar      english
        varchar      russian
        text         additional_info
        datetime     created
        datetime     modified
        int          lyrics_id
        int          id
    }

    Album        }|--o{  Artist : has
    Lyrics       }|--||    Song : has
    Media        }o--||    Song : has
    Song         }|--o|   Album : has
    Song         }o--|{  Artist : has
    Words        }o--||  Lyrics : has
```