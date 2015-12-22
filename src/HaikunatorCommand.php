<?php
/**
 * @license See the file LICENSE for copying permission
 */

namespace Atrox;

use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;
use ZF\Console\Route;

class HaikunatorCommand
{
    /**
     * @var Haikunator
     */
    protected $haikunator;

    public function __construct(Haikunator $haikunator = null)
    {
        if (! $haikunator) {
            $haikunator = new Haikunator();
        }

        $this->haikunator = $haikunator;
    }


    public function __invoke(Route $route, ConsoleAdapter $console)
    {
        $params = $this->getParamsFromRoute($route);
        $params = $this->filterNullParams($params);

        $this->setNounsFromRoute($route);
        $this->setAdjectivesFromRoute($route);

        $console->writeLine($this->haikunator->__invoke($params));
    }

    /**
     * @param Route $route
     *
     * @return array
     */
    protected function getParamsFromRoute(Route $route)
    {
        $params = [
            'tokenLength' => $route->getMatchedParam('token-length'),
            'tokenHex'    => ($route->getMatchedParam('token-hex') || $route->getMatchedParam('x')) ?: null,
            'tokenChars'  => $route->getMatchedParam('token-chars'),
            'delimiter'   => $route->getMatchedParam('delimiter'),
        ];

        return $params;
    }

    /**
     * @param $params
     *
     * @return array
     */
    protected function filterNullParams($params)
    {
        return array_filter($params, function ($value) {
            return $value !== null;
        });
    }

    /**
     * @param Route $route
     */
    protected function setNounsFromRoute(Route $route)
    {
        $nouns      = $route->getMatchedParam('nouns');
        if (! empty($nouns)) {
            Haikunator::$NOUNS = $this->getValuesFromFileIfExists($nouns);
        }
    }

    /**
     * @param Route $route
     */
    protected function setAdjectivesFromRoute(Route $route)
    {
        $adjectives = $route->getMatchedParam('adjectives');
        if (! empty($adjectives)) {
            Haikunator::$ADJECTIVES = $this->getValuesFromFileIfExists($adjectives);
        }
    }

    /**
     * @return array
     */
    protected function getValuesFromFileIfExists(array $values)
    {
        return count($values) === 1 && file_exists($values[0])
            ? preg_split('/[\s,]+/', file_get_contents($values[0]))
            : $values;
    }
}
