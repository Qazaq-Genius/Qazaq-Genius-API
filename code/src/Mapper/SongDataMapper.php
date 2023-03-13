<?php

namespace QazaqGenius\LyricsApi;

class SongDataMapper
{
    public function mapToSong(
        array $songData, array $artistData, array $albumData, array $lyricsData
    ): array
    {
        return [
            'id'            => $songData["id"],
            'created_by'    => $songData["created_by"] ?? null,
            'modified_by'   => $songData["modified_by"] ?? null,
            'created'       => $songData["created"],
            'modified'      => $songData["modified"],
            'release_date'  => $songData["release_date"],
            'title_cyr'     => $songData["title_cyr"],
            'title_lat'     => $songData["title_lat"],
            'artists'       => $this->mapArtists($artistData),
            'album'         => $this->mapAlbum($albumData),
            'lyrics'        => $this->mapLyrics($lyricsData)
        ];
    }

    private function mapArtists(array $artistData): array
    {
        $artists = [];
        foreach ($artistData as $artist) {
            $artists[] = [
                "id"        => $artist["artist_id"],
                "name_cyr"  => $artist["name_cyr"],
                "name_lat"  => $artist["name_lat"],
            ];
        }
        return $artists;
    }

    private function mapAlbum(array $albumData): array
    {
        $album = [
            "id"        => $albumData["id"] ?? null,
            "name_cyr"  => $albumData["name_cyr"] ?? null,
            "name_lat"  => $albumData["name_lat"] ?? null,
            "cover_art"  => $albumData["cover_art"] ?? null,
            "release_date"  => $albumData["release_date"] ?? null,
        ];

        return $album;
    }

    private function mapLyrics(array $lyricsData): array
    {
        $lyrics = [];
        foreach ($lyricsData as $line) {
            $lyrics[$line["verse_nr"]][$line["line_nr"]] = [
                "line_nr"       => $line["line_nr"],
                "qazaq_cyr"     => $line["qazaq_cyr"],
                "qazaq_lat"     => $line["qazaq_lat"],
                "english"       => $line["english"],
                "russian"       => $line["russian"],
                "original_lang" => $line["original_lang"],
            ];
        }
        return $lyrics;
    }
}
