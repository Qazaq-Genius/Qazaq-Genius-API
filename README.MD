# Qazaq Genius

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