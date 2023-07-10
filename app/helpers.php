<?php
/**
 * Perform a simple text replace
 * This should be used when the string does not contain HTML
 * (off by default)
 */
define('STR_HIGHLIGHT_SIMPLE', 1);

/**
 * Only match whole words in the string
 * (off by default)
 */
define('STR_HIGHLIGHT_WHOLEWD', 2);

/**
 * Case sensitive matching
 * (off by default)
 */
define('STR_HIGHLIGHT_CASESENS', 4);

/**
 * Overwrite links if matched
 * This should be used when the replacement string is a link
 * (off by default)
 */
define('STR_HIGHLIGHT_STRIPLINKS', 8);

/**
 * Highlight a string in text without corrupting HTML tags
 *
 * @author      Aidan Lister <aidan@php.net>
 *
 * @version     3.1.1
 *
 * @link        http://aidanlister.com/2004/04/highlighting-a-search-string-in-html-text/
 *
 * @param  string  $text           Haystack - The text to search
 * @param  array|string  $needle         Needle - The string to highlight
 * @param  bool  $options        Bitwise set of options
 * @param  array  $highlight      Replacement string
 * @return      Text with needle highlighted
 */
function str_highlight($text, $needle, $options = null, $highlight = null)
{
    // Default highlighting

    if ($highlight === null) {
        $highlight = '<strong>\1</strong>';
    }

    // Select pattern to use

    if ($options & STR_HIGHLIGHT_SIMPLE) {
        $pattern = '#(%s)#';
        $sl_pattern = '#(%s)#';
    } else {
        $pattern = '#(?!<.*?)(%s)(?![^<>]*?>)#';
        $sl_pattern = '#<a\s(?:.*?)>(%s)</a>#';
    }

    // Case sensitivity

    if (! ($options & STR_HIGHLIGHT_CASESENS)) {
        $pattern .= 'i';
        $sl_pattern .= 'i';
    }

    $needle = (array) $needle;
    foreach ($needle as $needle_s) {
        $needle_s = preg_quote($needle_s);

        // Escape needle with optional whole word check

        if ($options & STR_HIGHLIGHT_WHOLEWD) {
            $needle_s = '\b'.$needle_s.'\b';
        }

        // Strip links

        if ($options & STR_HIGHLIGHT_STRIPLINKS) {
            $sl_regex = sprintf($sl_pattern, $needle_s);
            $text = preg_replace($sl_regex, '\1', $text);
        }

        $regex = sprintf($pattern, $needle_s);
        $text = preg_replace($regex, $highlight, $text);
    }

    return $text;
}

function get_snippet($str, $wordCount = 10)
{
    return implode(
        '',
        array_slice(
            preg_split(
                '/([\s,\.;\?\!]+)/',
                $str,
                $wordCount * 2 + 1,
                PREG_SPLIT_DELIM_CAPTURE
            ),
            0,
            $wordCount * 2 - 1
        )
    );
}

function get_word_count($str)
{
    return count(
        preg_split(
            '/([\s,\.;\?\!]+)/',
            $str,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        )
    );
}

function monthName($monthNum)
{
    if (empty($monthNum)) {
        return '';
    }
    $dateObj = DateTime::createFromFormat('!m', $monthNum);

    return $dateObj->format('F');
}

function getScriptureLink($scripture)
{
    //ray('Scripture Match: '.$scripture);
    $book = str($scripture)->match('/([1-9]*\s?[A-Za-z\s—]+)/s')->toString();
    // ray('Book Match: '.$book);
    $reference = str($scripture)->after($book)->match('/([0-9]+:?[0-9-,]*)/s');
    // ray('Reference Match: '.$reference);
    $volume = getVolume($book);
    $verseRange = '';
    // Sometimes the verse is a range "1-4" or might be non-existent
    if ($reference->isEmpty()) {
        $chapter = '';
        $verse = '';
    } elseif ($reference->contains(':')) {
        $chapter = $reference->explode(':')->first();
        $verse = $reference->explode(':')->last();
        $verseRange = "p$verse";
        // ray($verse);
        if (str($verse)->contains('-')) {
            $verseRange = str($verse)->explode('-')->map(function ($item) {
                return "p$item";
            })->join('-');
            $verse = str($verse)->explode('-')->first();
        }
        if (str($verse)->contains(',')) {
            $verseRange = str($verse)->explode(',')->map(function ($item) {
                return 'p'.trim($item);
            })->join(',');
            $verse = str($verse)->explode(',')->first();
        }
    } else {
        $chapter = $reference->explode('-')->first();
        $verse = '';
    }

    $query = '';
    if (! empty($volume)) {
        //ray('Volume: '.$volume);
        $query .= $volume;
    }
    if (! empty($bookAbbreviation = getBookAbbreviation($book))) {
        //ray('Book Abbreviation: '.$bookAbbreviation);
        $query .= "/$bookAbbreviation";
    }
    if (! empty($chapter)) {
        //ray('Chapter: '.$chapter);
        $query .= "/$chapter";
    }
    if (! empty($verse)) {
        //ray('Verse: '.$verse);
        $query .= "?lang=eng&id=$verseRange#p$verse";
    } else {
        $query .= '?lang=eng';
    }

    return "https://www.churchofjesuschrist.org/study/scriptures/$query";
    // Example: https://www.churchofjesuschrist.org/study/scriptures/ot/josh/1?lang=eng&id=p8#p8
}

function getVolume($volume)
{
    // ray('Volume: '.$volume);

    return match (trim($volume)) {
        'Genesis', 'Exodus', 'Leviticus', 'Numbers', 'Deuteronomy', 'Joshua', 'Judges', 'Ruth', '1 Samuel', '2 Samuel', '1 Kings', '2 Kings', '1 Chronicles', '2 Chronicles', 'Ezra', 'Nehemiah', 'Esther', 'Job', 'Psalms', 'Proverbs', 'Ecclesiastes', 'Song of Solomon', 'Isaiah', 'Jeremiah', 'Lamentations', 'Ezekiel', 'Daniel', 'Hosea', 'Joel', 'Amos', 'Obadiah', 'Jonah', 'Micah', 'Nahum', 'Habakkuk', 'Zephaniah', 'Haggai', 'Zechariah', 'Malachi' => 'ot',
        'Matthew', 'Mark', 'Luke', 'John', 'Acts', 'Romans', '1 Corinthians', '2 Corinthians', 'Galatians', 'Ephesians', 'Philippians', 'Colossians', '1 Thessalonians', '2 Thessalonians', '1 Timothy', '2 Timothy', 'Titus', 'Philemon', 'Hebrews', 'James', '1 Peter', '2 Peter', '1 John', '2 John', '3 John', 'Jude', 'Revelation' => 'nt',
        '1 Nephi', '2 Nephi', 'Jacob', 'Enos', 'Jarom', 'Omni', 'Words of Mormon', 'Mosiah', 'Alma', 'Helaman', '3 Nephi', '4 Nephi', 'Mormon', 'Ether', 'Moroni' => 'bofm',
        'D&C', 'Doctrine and Covenants', 'Doctrine & Covenants' => 'dc-testament',
        'Moses', 'Abraham', 'Joseph Smith—Matthew', 'Joseph Smith — Matthew', 'Joseph Smith-Matthew', 'Joseph Smith - Matthew', 'Joseph Smith—History', 'Joseph Smith — History', 'Joseph Smith-History', 'Joseph Smith - History' => 'pgp',
        default => '',
    };
}

function getBookAbbreviation($book)
{
    // ray('Book: '.$book);

    return match (trim($book)) {
        'Genesis' => 'gen', // Old Testament
        'Exodus' => 'ex',
        'Leviticus' => 'lev',
        'Numbers' => 'num',
        'Deuteronomy' => 'deut',
        'Joshua' => 'josh',
        'Judges' => 'judg',
        'Ruth' => 'ruth',
        '1 Samuel' => '1-sam',
        '2 Samuel' => '2-sam',
        '1 Kings' => '1-kgs',
        '2 Kings' => '2-kgs',
        '1 Chronicles' => '1-chr',
        '2 Chronicles' => '2-chr',
        'Ezra' => 'ezra',
        'Nehemiah' => 'neh',
        'Esther' => 'esth',
        'Job' => 'job',
        'Psalms' => 'ps',
        'Proverbs' => 'prov',
        'Ecclesiastes' => 'eccl',
        'Song of Solomon' => 'song',
        'Isaiah' => 'isa',
        'Jeremiah' => 'jer',
        'Lamentations' => 'lam',
        'Ezekiel' => 'ezek',
        'Daniel' => 'dan',
        'Hosea' => 'hosea',
        'Joel' => 'joel',
        'Amos' => 'amos',
        'Obadiah' => 'obad',
        'Jonah' => 'jonah',
        'Micah' => 'micah',
        'Nahum' => 'nahum',
        'Habakkuk' => 'hab',
        'Zephaniah' => 'zeph',
        'Haggai' => 'hag',
        'Zechariah' => 'zech',
        'Malachi' => 'mal',
        'Matthew' => 'matt', // New Testament
        'Mark' => 'mark',
        'Luke' => 'luke',
        'John' => 'john',
        'Acts' => 'acts',
        'Romans' => 'rom',
        '1 Corinthians' => '1-cor',
        '2 Corinthians' => '2-cor',
        'Galatians' => 'gal',
        'Ephesians' => 'eph',
        'Philippians' => 'philip',
        'Colossians' => 'col',
        '1 Thessalonians' => '1-thes',
        '2 Thessalonians' => '2-thes',
        '1 Timothy' => '1-tim',
        '2 Timothy' => '2-tim',
        'Titus' => 'titus',
        'Philemon' => 'philem',
        'Hebrews' => 'heb',
        'James' => 'james',
        '1 Peter' => '1-pet',
        '2 Peter' => '2-pet',
        '1 John' => '1-jn',
        '2 John' => '2-jn',
        '3 John' => '3-jn',
        'Jude' => 'jude',
        'Revelation' => 'rev',
        '1 Nephi' => '1-ne', // Book of Mormon
        '2 Nephi' => '2-ne',
        'Jacob' => 'jacob',
        'Enos' => 'enos',
        'Jarom' => 'jarom',
        'Omni' => 'omni',
        'Words of Mormon' => 'w-o-m',
        'Mosiah' => 'mosiah',
        'Alma' => 'alma',
        'Helaman' => 'hel',
        '3 Nephi' => '3-ne',
        '4 Nephi' => '4-ne',
        'Mormon' => 'morm',
        'Ether' => 'ether',
        'Moroni' => 'moro',
        'D&C', 'Doctrine and Covenants', 'Doctrine & Covenants' => 'dc',
        'Moses' => 'moses',
        'Abraham' => 'abr',
        'Joseph Smith—Matthew', 'Joseph Smith — Matthew', 'Joseph Smith-Matthew', 'Joseph Smith - Matthew' => 'js-m',
        'Joseph Smith—History', 'Joseph Smith — History', 'Joseph Smith-History', 'Joseph Smith - History' => 'js-h',
        default => '',
    };
}
