<?php

namespace App\Enums;

enum PartOfSpeech: string
{
    case Adjective    = 'adjective';

    case Adverb       = 'adverb';

    case Article      = 'article';

    case Conjunction  = 'conjunction';

    case Determiner   = 'determiner';

    case Expression   = 'expression';

    case Interjection = 'interjection';

    case Noun         = 'noun';

    case Numeral      = 'numeral';

    case Preposition  = 'preposition';

    case Pronoun      = 'pronoun';

    case ProperNoun   = 'proper noun';

    case Sentence     = 'sentence';

    case Verb         = 'verb';
}
