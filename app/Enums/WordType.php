<?php

namespace App\Enums;

enum WordType: string
{
    case Adjective    = 'adjective';

    case Adverb       = 'adverb';

    case Article      = 'article';

    case Conjunction  = 'conjunction';

    case Expression   = 'expression';

    case Interjection = 'interjection';

    case Noun         = 'noun';

    case Number       = 'number';

    case Preposition  = 'preposition';

    case Pronoun      = 'pronoun';

    case Verb         = 'verb';

    case Unknown      = 'unknown';
}
