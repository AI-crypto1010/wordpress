<?php

function generateCategoriesArray($items, $applyCustomTitles = false, $specialOrder = []) {
    $categoriesCount = [];

    $WarningsCounter = 0;
    foreach ($items as $item) {
        if (isset($item['categories']) && is_array($item['categories'])) {
            foreach ($item['categories'] as $category) {
                if (!isset($categoriesCount[$category])) {
                    $categoriesCount[$category] = 0;
                }
                $categoriesCount[$category]++;
            }
        } else {
            // Handle the case where $item['categories'] is not an array
            error_log('Warning: $item["categories"] is not an array or is not set.');
            error_log(print_r($item, true));
            $WarningsCounter++;
            error_log('[Warnings Count]: ' . $WarningsCounter);
        }
    }

    $customTitles = [
        'contact' => 'Contact Information',
        'cta' => 'CTA',
        'popups' => 'Popups Content'
        // Add more custom titles here if needed
    ];

    $categoriesArray = [];
    foreach ($categoriesCount as $category => $count) {
        if ($applyCustomTitles && isset($customTitles[$category])) {
            $title = $customTitles[$category];
        } else {
            $title = ucwords(str_replace('_', ' ', $category));
        }
        $categoriesArray[] = [
            'title' => $title,
            'number' => $count,
            'id' => $category
        ];
    }

    // Add the 'All' category
    array_unshift($categoriesArray, [
        'title' => 'All',
        'number' => count($items),
        'id' => 'all'
    ]);

    // Custom order for special categories
    usort($categoriesArray, function($a, $b) use ($specialOrder) {
        $posA = array_search($a['title'], $specialOrder);
        $posB = array_search($b['title'], $specialOrder);

        if ($posA === false && $posB === false) {
            return strcmp($a['title'], $b['title']);
        }

        if ($posA === false) {
            return 1; // B goes first
        }

        if ($posB === false) {
            return -1; // A goes first
        }

        return $posA - $posB; // Sort by position in the special order array
    });

    return $categoriesArray;
}