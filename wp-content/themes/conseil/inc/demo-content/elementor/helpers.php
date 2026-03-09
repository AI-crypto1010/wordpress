<?php

/**
 * Generate templates array from templates list
 * 
 * @param array $templatesList Array of template definitions with demo_name, title, categories, and optional flags
 * @param string $sectionType The section type (e.g., 'intros', 'features', 'content', 'pages')
 * @param string $thumbPath The base path for thumbnails
 * @return array Array of formatted templates
 */
function pix_generate_templates($templatesList, $sectionType, $thumbPath) {
    $templates = array();
    
    // Determine if this is for pages or sections
    $isPages = ($sectionType === 'pages');
    $filePath = $isPages ? 'pages/' : 'sections/' . $sectionType . '/';
    $templateType = $isPages ? 'page' : 'block';
    
    foreach ($templatesList as $template) {
        $demo_name = strtolower(str_replace(' ', '-', $template['demo_name']));
        $full_title = $template['demo_name'] . ' ' . $template['title'];
        $name_with_hyphens = str_replace(' ', '-', strtolower($full_title));
        
        $data = array(
            'id' => $name_with_hyphens,
            'file' => $filePath . $name_with_hyphens . '.json',
            'title' => $full_title,
            'thumbnail' => $thumbPath . $name_with_hyphens . '.webp',
            'url' => 'https://conseil.pixfort.com/' . $demo_name . '/templates-library/?template=' . $name_with_hyphens,
            'type' => $templateType,
            'categories' => $template['categories'],
        );
        
        // Add optional flags if present
        if (isset($template['dynamic']) && $template['dynamic']) {
            $data['dynamic'] = true;
        }
        
        array_push($templates, $data);
    }
    
    return $templates;
}

