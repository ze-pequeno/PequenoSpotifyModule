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

namespace PequenoSpotifyModule;

use Zend\Http;

class Spotify
{
    /** @var Http\Client */
    private $httpClient;

    /**
	 * Class constructor
	 * @access public
	 * @param Http\Client $httpClient Http client
	 */
    public function __construct(Http\Client $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
	 * Get current Http client instance
	 * @access public
	 * @return Http\Client
	 */
    public function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = new Http\Client();
        }

        return $this->httpClient;
    }

    /**
	 * Set current Http client instance
	 * @access public
	 * @param Http\Client $httpClient Http client instance
	 * @return Spotify
	 */
    public function setHttpClient(Http\Client $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }
}