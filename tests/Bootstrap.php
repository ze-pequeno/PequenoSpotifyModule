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

// set namespace
namespace PequenoSpotifyModuleTest;

// set used namespaces
use PequenoSpotifyModuleTest\Utils\Bootstrap;

// enable all error reporting
error_reporting(E_ALL | E_STRICT);

// require Bootstrap class
require __DIR__.'/PequenoSpotifyModuleTest/Utils/Bootstrap.php';

// include configuration file
$files = array(__DIR__.'/TestConfiguration.php', __DIR__.'/TestConfiguration.php.dist');
foreach ($files as $file) {
    if (file_exists($file)) {
        /** @noinspection PhpIncludeInspection */
        $config = require $file;
        break;
    }
}

// throw if no valid configuration found
if (!isset($config))
    throw new \RuntimeException(sprintf('no valid configuration file found : %s', implode(', ', $files)));

// init Boostrap class
Bootstrap::init($config);
