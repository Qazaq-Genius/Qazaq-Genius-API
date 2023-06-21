<?php

namespace QazaqGenius\LyricsApi;

use QazaqGenius\Transliterator as Qazaq;

class SongDataMapper
{
    public function mapToSong(
        array $songData,
        array $artistData,
        array $albumData,
        array $lyricsData,
        array $wordData,
        array $mediaData
    ): array {
        return [
            'id'            => $songData["id"],
            'created_by'    => $songData["created_by"] ?? null,
            'modified_by'   => $songData["modified_by"] ?? null,
            'created'       => $songData["created"],
            'modified'      => $songData["modified"],
            'release_date'  => $songData["release_date"],
            'title_cyr'     => $songData["title_cyr"],
            'title_lat'     => $songData["title_lat"],
            "cover_art"     => $songData["cover_art"] ?? $albumData["cover_art"] ?? null,
            "media"         => $this->mapMedia($mediaData),
            'artists'       => $this->mapArtists($artistData),
            'album'         => $this->mapAlbum($albumData),
            'lyrics'        => $this->mapLyrics($lyricsData, $wordData)
        ];
    }

    private function mapMedia(array $mediaData): array
    {
        $media = [];

        foreach ($mediaData as $mediaColumn) {
            $name = $mediaColumn["name"];
            $media[$name] = $mediaColumn["url"];
        }

        return $media;
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

    private function mapLyrics(array $lyricsData, array $wordData): array
    {
        $lyrics = [];
        foreach ($lyricsData as $current_line) {
            $verse = $current_line["verse_nr"];
            $line  = $current_line["line_nr"];

            $lyrics[$verse][$line] = [
                "line_nr"       => $current_line["line_nr"],
                "qazaq_cyr"     => $current_line["qazaq_cyr"],
                "qazaq_lat"     => Qazaq::toLatin($current_line["qazaq_cyr"]),
                "english"       => $current_line["english"],
                "russian"       => $current_line["russian"],
                "original_lang" => $current_line["original_lang"],
            ];

            $lyrics[$verse][$line]["words"] = $this->mapWordsToLyrics($wordData, $current_line["id"]);
        }
        return $lyrics;
    }

    private function mapWordsToLyrics(array $wordData, int $current_line_id): array
    {
        $words = [];
        foreach ($wordData as $wordArray) {
            if ($this->areThereWordsInLine($wordArray, $current_line_id)) {
                $words = $this->mapWordsToLine($wordArray);
            }
        }
        return $words;
    }

    private function areThereWordsInLine(array $wordArray, int $current_line_id): bool
    {
        return isset($wordArray[0]) && $wordArray[0]["lyrics_id"] === $current_line_id;
    }

    private function mapWordsToLine(array $wordArray): array
    {
        $words = [];
        foreach ($wordArray as $word) {
            $words[] = [
                "word_in_line_nr" => $word["word_in_line_nr"],
                "qazaq_cyr"       => $word["qazaq_cyr"],
                "qazaq_lat"       => Qazaq::toLatin($word["qazaq_cyr"]),
                "english"         => $word["english"],
                "russian"         => $word["russian"],
            ];
        }
        return $words;
    }
}
