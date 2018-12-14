<?php
/*
 * This file is part of the PxlCtzn Website project.
 *
 * Copyright (C) 2018 PxlCtzn
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <https://www.gnu.org/licenses/>.
 */
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Asset\Packages;

class JsonExtension extends AbstractExtension
{

    private $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('json_decode', [$this, 'jsonDecode']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('jsonLoad', [$this, 'jsonLoad']),
        ];
    }

    /**
     * @link http://www.php.net/manual/en/function.json-decode.php
     */
    public function jsonDecode($value)
    {
        return json_decode($value, true);
    }

    public function jsonLoad($path)
    {
        $url = getcwd() .DIRECTORY_SEPARATOR. $this->packages->getUrl($path);

        $content = file_get_contents($url);
        if (false === $content) {
            Throw new \Twig_Error_Runtime("Could not load the '$path' JSON file.");
        }

        $jsonObject = json_decode($content, true);
        return $jsonObject;
    }

    public function getName()
    {
        return 'json';
    }
}
