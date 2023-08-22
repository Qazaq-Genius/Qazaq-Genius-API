<?php

namespace QazaqGenius\LyricsApi;

class SearchResultMapper
{
    public function map(array $searchData, array $artistData): array
    {
        return [
            "song" => $this->addArtist($searchData["song"], $artistData),
            "artist" => $this->addArtist($searchData["artist"], $artistData)
        ];
    }

    private function addArtist(array $searchData, array $artistData): array
    {
        foreach ($searchData as $id => $searchResult) {
            $searchData[$id]["artists"] = $artistData[$id];
        }

        return array_values($searchData);
    }

}