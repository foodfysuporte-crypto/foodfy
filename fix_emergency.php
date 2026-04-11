<?php
$file = 'app/Views/templates/sidebar.php';
$content = file_get_contents($file);

// Remove the orphan endif at line 176 (or wherever it is now)
// We'll search for the specific problematic block
$target = "                <?php endif; ?>\n                    <li id=\"2.x\"";
$replacement = "                    <li id=\"2.x\"";

if (strpos($content, $target) !== false) {
    $content = str_replace($target, $replacement, $content);
    
    // Also remove any other orphan endif around there
    $target2 = "<?php endif; ?>\n                    <!-- <?php if (";
    $replacement2 = "<!-- <?php if (";
    $content = str_replace($target2, $replacement2, $content);

    file_put_contents($file, $content);
    echo "Fixed sidebar syntax.";
} else {
    echo "Target block not found. Trying alternative...";
    // Just remove all endif; ?> and we will re-apply properly
    // Actually, let's just target the specific line we saw in view_file
    $lines = explode("\n", $content);
    // Line 176 in view_file was the 176th line.
    unset($lines[175]); 
    // And if 167 is also invalid (no if at 125)
    unset($lines[166]);
    
    file_put_contents($file, implode("\n", $lines));
    echo "Emergency cleanup done.";
}
