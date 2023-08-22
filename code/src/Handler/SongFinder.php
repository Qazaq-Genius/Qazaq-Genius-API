<?php

namespace QazaqGenius\LyricsApi;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SongFinder
{
    public function __construct(
        private MySQLSongReader $mySqlSongReader,
        private MySQLArtistReader $mySqlArtistReader,
        private MySQLAlbumReader $mySqlAlbumReader,
        private SearchResultMapper $searchResultMapper
    ) {
    }

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Response $response): Response
    {
        if ($request->getQueryParams() === []) {
            return ApiResponse::errorMissingQueryParam(['keyword']);
        }

        $keyword = $request->getQueryParams()['keyword'];

        if ($keyword === "") {
            return ApiResponse::errorMissingQueryParam(['keyword']);
        }

        $searchData = $this->mySqlSongReader->getSongByName($keyword);
        $songIds = $this->getSongIdsFromQueryResult($searchData);

        $artistData = [];
        foreach ($songIds as $id) {
            $artistData[$id] = $this->mySqlArtistReader->getArtistBySongIdSorted($id);
        }

        $result = $this->searchResultMapper->map($searchData, $artistData);

        return ApiResponse::sucessful($response, $result);
    }

    private function getSongIdsFromQueryResult(array $searchResults): array
    {
        $songIds = [];

        foreach ($searchResults['song'] as $key => $searchResult) {
            $songIds[] = $key;
        }

        foreach ($searchResults['artist'] as $key => $searchResult) {
            $songIds[] = $key;
        }

        //filter duplicate song IDs
        $songIds = array_flip(array_flip($songIds));

        return $songIds;
    }
}
