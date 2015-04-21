<?php

/**
 *    Prints a heading showing a team member and the browser that they will be testing.
 *
 * @param   string $teamMember  Team members name
 * @param   string $browser     Browser name
 *
 */
function printHeading($teamMember, $browser)
{

    $headingFormat = "<li class='list-group-item active'><h2>%s <small><span class='label label-default'>%s</span></small></h2></li>";

    printf($headingFormat, $teamMember, $browser);

}


/**
 *    Prints a specified number of pages to be tested
 *
 * @param   int     $numberOfPagesPerTester The number of pages that each individual tester should test
 * @param   array   $pages Array representing all pages available for testing (NOTE: This is passed by reference)
 * @param   array   $pagesAlwaysTested Array representing those high profile pages which are always tested
 * @var     int     $numberOfAlwaysTestedPages The number of pages that are always tested. This is used in the loop and deducted from
 *                  the number of pages that each individual tester should test
 *
 */
function printPagesToTest($numberOfPagesPerTester, &$pages, &$pagesAlwaysTested)
{

    $k = 1;

    $items = array();

    $numberOfAlwaysTestedPages = 3;

    // Everyone gets a couple of $pagesAlwaysTested

    for ($i = 0; $i < $numberOfAlwaysTestedPages; $i++) {

        $pageAlwaysTested = array_pop($pagesAlwaysTested);

        if ($pageAlwaysTested !== NULL) {

            $liFormat = "<li class='list-group-item'><span class='label label-warning'>Page always tested</span> %s <div class='btn-group'><a href='%s' class='btn btn-default' target='_blank'>Test</a> <a href='%s' class='btn btn-default' target='_blank'>Live</a></div></li>";

            $items[] = sprintf($liFormat, str_replace('http://testlb.nationalarchives.gov.uk', '', $pageAlwaysTested), $pageAlwaysTested, str_replace('testlb', 'www', $pageAlwaysTested));

        }
    }


    // Selection of random pages
    while ($k <= ($numberOfPagesPerTester - $numberOfAlwaysTestedPages)) {

        $page = array_pop($pages);

        if (pageShouldBeTested($page)) {

            $liFormat = "<li class='list-group-item'>%s <div class='btn-group'><a href='%s' class='btn btn-default' target='_blank'>Test</a> <a href='%s' class='btn btn-default' target='_blank'>Live</a></div></li>";

            $items[] = sprintf($liFormat, str_replace('http://testlb.nationalarchives.gov.uk', '', $page), $page, str_replace('testlb', 'www', $page));

            $k++;
        }
    }

    printf("<ul class='list-group'>%s</ul>", implode($items));

}

/**
 *    Determines if a specific page should be excluded from the testing based on it containing a specific sub-string.
 *    This has been included to prevent certain page types being over-represented in testing (for example, while almost 2/3 of all
 *    pages are education resources, all of these use the same template and styles and they should not therefore be over-represented)
 *
 * @param   string $candidateHaystack   String to search
 *
 * @var     array $overRepresentedPages Array of strings which, if found in the tested URL, mean is likely to be over-represented in results.
 *                                      For this reason, only 20% of such pages will considered OK to include (using rand())
 *
 * @return  bool                        True indicates the page can be included in testing, False that it should be excluded.
 */

function pageShouldBeTested($candidateHaystack)
{
    $overRepresentedPages = array('beta', 'resources');

    $proceed = true;

    foreach ($overRepresentedPages as $value) {

        if (strpos($candidateHaystack, $value)) {

            $proceed = false;

        }
    }

    return $proceed;

}

/**
 *    Generates the full list of testers and the pages they'll be testing
 *
 * @param   array   $testers    Associative array of testers. Keys are tester name, values are browser name
 *
 * @param   array   $pages      Array representing all pages available for testing
 *
 */

function generateTestScript($testers, $pages, $pagesAlwaysTested)
{

    foreach ($testers as $key => $value) {

        printHeading($key, $value);

        printPagesToTest(20, $pages, $pagesAlwaysTested);

    }
}