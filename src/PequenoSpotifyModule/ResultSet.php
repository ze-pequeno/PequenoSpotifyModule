<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

// set class namespace
namespace PequenoSpotifyModule;

// set used namespaces
use PequenoSpotifyModule\Service\SpotifyService;
use PequenoSpotifyModule\Item\AbstractItem;
use PequenoSpotifyModule\Item\Album;
use PequenoSpotifyModule\Item\Artist;
use PequenoSpotifyModule\Item\Track;

class ResultSet implements \Iterator, \Countable
{
    /** @var int */
    protected $numResults = null;

    /** @var int */
    protected $limit = null;

    /** @var int */
    protected $offset = null;

    /** @var string */
    protected $query = null;

    /** @var string */
    protected $type = null;

    /** @var int */
    protected $numPage = null;

    /** @var AbstractItem[] */
    protected $results = null;

    /**
     * Class contructor
     * @access public
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    public function __construct($rawResults)
    {
        // extract search informations
        $this->extractSearchInfos($rawResults);

        // extract search results
        $this->extractSearchResults($rawResults);
    }

    /**
     * Get result total count
     * @access public
     * @return int
     */
    public function getSizeOfResults()
    {
        // return result total count
        return $this->numResults;
    }

    /**
     * Add AbstractItem on search results
     * @access private
     * @param  AbstractItem   $item item to add at search results
     * @return AbstractItem[]
     */
    private function addSearchResult($item)
    {
        // create container if necessary
        if (!is_array($this->results)) {

            // create result container
            $this->results = array();
        }

        // check we have an AbstractItem instance
        if ($item instanceof AbstractItem) {

            // add item to container
            $this->results[] = $item;
        }

        // return container
        return $this->results;
    }

    /**
     * Extract search informations
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractSearchInfos($rawResults)
    {
        // is search informations available ?
        if (isset($rawResults->info)) {

            // get search informations
            $this->numResults = (int) $rawResults->info->num_results;
            $this->numPage = (int) $rawResults->info->page;
            $this->limit = (int) $rawResults->info->limit;
            $this->offset = (int) $rawResults->info->offset;
            $this->query = (string) $rawResults->info->query;
            $this->type = (string) $rawResults->info->type;
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search result items
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractSearchResults($rawResults)
    {
        switch ($this->type) {
            // albums search
            case SpotifyService::SEARCH_ALBUM:
                $this->extractAlbums($rawResults);
                break;
            // artists search
            case SpotifyService::SEARCH_ARTIST:
                $this->extractArtists($rawResults);
                break;
            // tracks search
            case SpotifyService::SEARCH_TRACK:
                $this->extractTracks($rawResults);
                break;
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search albums
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractAlbums($rawResults)
    {
        // are albums available ?
        if (isset($rawResults->albums) && is_array($rawResults->albums)) {

            // iterate albums
            foreach ($rawResults->albums as $album) {

                // create album instance
                $albumItem = Album::extractInfos($album);

                // store search result
                $this->addSearchResult($albumItem);
            }
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search artists
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractArtists($rawResults)
    {
        // are artists available ?
        if (isset($rawResults->artists) && is_array($rawResults->artists)) {

            // iterate artists
            foreach ($rawResults->artists as $artist) {

                // create artist instance
                $artistItem = Artist::extractInfos($artist);

                // store search result
                $this->addSearchResult($artistItem);
            }
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search tracks
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractTracks($rawResults)
    {
        // are tracks available ?
        if (isset($rawResults->tracks) && is_array($rawResults->tracks)) {

            // iterate tracks
            foreach ($rawResults->tracks as $track) {

                // create Track instance
                $trackItem = Track::extractInfos($track);

                // store search result
                $this->addSearchResult($trackItem);
            }
        }

        // return ResultSet
        return $this;
    }

    /**
     * Get search resultat as indice
     * @access public
     * @param  int               $indice Search result indice
     * @return AbstractItem|null
     */
    public function getResultAt($indice)
    {
        // return AbstractItem if exist, else null
        return (isset($this->results[$indice])) ? $this->results[$indice] : null;
    }

    /**
     * Get current search AbstractItem
     * @access public
     * @return AbstractItem
     */
    public function current()
    {
        // return current AbstractItem
        return current($this->results);
    }

    /**
     * Move cursor to next position
     * @access public
     * @return void
     */
    public function next()
    {
        next($this->results);
    }

    /**
     * Get current cursor position
     * @access public
     * @return int
     */
    public function key()
    {
        return key($this->results);
    }

    /**
     * Is current cursor position valid ?
     * @access public
     * @return bool
     */
    public function valid()
    {
        return (bool) (($this->key() !== null) && ($this->key() !== false));
    }

    /**
     * Rest cursor position to start
     * @access public
     * @return void
     */
    public function rewind()
    {
        reset($this->results);
    }

    /**
     * Get search results count (from query, not total)
     * @access public
     * @return int
     */
    public function count()
    {
        // return search result count
        return count($this->results);
    }
}
