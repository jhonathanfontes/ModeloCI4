<?php

namespace App\Libraries\Twig;

use Twig\Error\LoaderError;
use Twig\Loader\FilesystemLoader;

class TwigLoader extends FilesystemLoader
{
    private const EXTENSIONS = ['.html.twig', '.twig'];

    protected function findTemplate(string $name, bool $throw = true): ?string
    {
        if (pathinfo($name, PATHINFO_EXTENSION)) {
            return parent::findTemplate($name, $throw);
        }

        foreach (self::EXTENSIONS as $ext) {
            try {
                $result = parent::findTemplate($name . $ext, false);
                if ($result !== null) {
                    return $result;
                }
            } catch (LoaderError) {
                continue;
            }
        }

        if ($throw) {
            throw new LoaderError(sprintf(
                'Unable to find template "%s" (tried: %s).',
                $name,
                implode(', ', self::EXTENSIONS)
            ));
        }

        return null;
    }
}
