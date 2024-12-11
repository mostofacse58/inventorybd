$directory = './application/models'; // Change this to your target directory

// Open the directory
        if ($handle = opendir($directory)) {
            while (false !== ($file = readdir($handle))) {
                // Skip current and parent directory indicators
                if ($file !== '.' && $file !== '..') {
                    // Check if the file has a .php extension
                    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                        // Get the current filename and generate the new filename
                        $newName = ucfirst($file);

                        // Rename the file if the name has changed
                        if ($newName !== $file) {
                            rename($directory . '/' . $file, $directory . '/' . $newName);
                            echo "Renamed: $file to $newName\n";
                        }
                    }
                }
            }
            closedir($handle);
        } else {
            echo "Failed to open directory: $directory";
        }

    exit;