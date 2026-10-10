<?php

/**
 * GitHub Repository Tag Comparison Script
 * 
 * This script fetches the latest and previous tags from a GitHub repository
 * and lists all file changes between them.
 */

/**
 * Makes a GET request to the GitHub API.
 *
 * @param string $url The full API URL to request.
 * @return array|null The decoded JSON response, or null on failure.
 */
function githubApiRequest($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-Script');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    // Uncomment and add your token for higher rate limits (5000/hr vs 60/hr)
    // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: token YOUR_GITHUB_TOKEN']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    if ($curlError) {
        error_log("cURL error: " . $curlError);
        return null;
    }

    if ($httpCode !== 200) {
        error_log("GitHub API request failed with code: " . $httpCode . " for URL: " . $url);
        return null;
    }

    return json_decode($response, true);
}

/**
 * Fetches all tags from a GitHub repository.
 *
 * @param string $owner The repository owner.
 * @param string $repo The repository name.
 * @return array An array of tags, or an empty array on failure.
 */
function getAllTags($owner, $repo)
{
    $url = "https://api.github.com/repos/{$owner}/{$repo}/tags?per_page=100";
    $data = githubApiRequest($url);

    if (!is_array($data)) {
        return [];
    }

    return $data;
}

/**
 * Fetches the latest and previous tags from a GitHub repository.
 * Tags are ordered by the date they were created (newest first).
 *
 * @param string $owner The repository owner.
 * @param string $repo The repository name.
 * @return array An array with 'latest' and 'previous' keys (values may be null).
 */
function getLatestAndPreviousTags($owner, $repo)
{
    $url = "https://api.github.com/repos/{$owner}/{$repo}/tags?per_page=2";
    $data = githubApiRequest($url);

    if (!is_array($data)) {
        return ['latest' => null, 'previous' => null];
    }

    return [
        'latest'   => $data[0]['name'] ?? null,
        'previous' => $data[1]['name'] ?? null,
    ];
}

/**
 * Fetches the latest tag from a GitHub repository.
 *
 * @param string $owner The repository owner.
 * @param string $repo The repository name.
 * @return string|null The latest tag name, or null on failure.
 */
function getLatestTag($owner, $repo)
{
    $tags = getLatestAndPreviousTags($owner, $repo);
    return $tags['latest'];
}

/**
 * Fetches the list of changed files between two tags from a GitHub repository.
 *
 * @param string $owner The repository owner.
 * @param string $repo The repository name.
 * @param string $baseTag The older tag to compare from.
 * @param string $headTag The newer tag to compare to.
 * @return array An array of file change objects, or an empty array on failure.
 */
function getChangedFilesForTag($owner, $repo, $baseTag, $headTag)
{
    $url = "https://api.github.com/repos/{$owner}/{$repo}/compare/{$baseTag}...{$headTag}";
    $data = githubApiRequest($url);

    if (!is_array($data)) {
        return [];
    }

    // The 'files' key contains the list of changes.
    if (isset($data['files']) && is_array($data['files'])) {
        return $data['files'];
    }

    return [];
}

/**
 * Sorts an array of tags by semantic version (descending).
 *
 * @param array $tags Array of tag objects from the GitHub API.
 * @return array Sorted array of tag objects.
 */
function sortTagsBySemver(array $tags)
{
    usort($tags, function ($a, $b) {
        return version_compare(
            ltrim($b['name'], 'vV'),
            ltrim($a['name'], 'vV')
        );
    });
    return $tags;
}

// ============================================================
// --- Usage ---
// ============================================================

$owner = 'YroDevGit';
$repo  = 'ctrx';

echo "========================================\n";
echo "Fetching tags for {$owner}/{$repo}...\n";
echo "========================================\n\n";

// Get the latest and previous tags
$tags = getLatestAndPreviousTags($owner, $repo);

if ($tags['latest'] === null) {
    die("Could not fetch tags for {$owner}/{$repo}.\n");
}

$headTag = $tags['latest'];
$baseTag = "v5.9.1";

echo "Latest tag:   {$headTag}\n";
echo "Previous tag: " . ($baseTag ?? '(none)') . "\n\n";

if ($baseTag === null) {
    die("No previous tag found to compare against.\n");
}

// Fetch the changed files between the two tags
echo "========================================\n";
echo "Comparing {$baseTag}...{$headTag}\n";
echo "========================================\n\n";

$changedFiles = getChangedFilesForTag($owner, $repo, $baseTag, $headTag);

if (empty($changedFiles)) {
    echo "No file changes found (or an error occurred).\n";
    exit;
}

echo "Total files changed: " . count($changedFiles) . "\n\n";

// Group changes by status for a nicer summary
$byStatus = [];
foreach ($changedFiles as $file) {
    $status = $file['status'] ?? 'unknown';
    $byStatus[$status][] = $file;
}

// Display a summary count
echo "--- Summary by status ---\n";
foreach ($byStatus as $status => $files) {
    echo sprintf("  %-10s %d\n", $status . ':', count($files));
}
echo "\n";

// Display detailed file list
echo "--- Detailed file changes ---\n";
foreach ($changedFiles as $file) {
    $status   = $file['status']   ?? 'unknown';
    $filename = $file['filename'] ?? '(unknown)';
    $adds     = $file['additions'] ?? 0;
    $dels     = $file['deletions'] ?? 0;

    $line = sprintf("[%-8s] %s (+%d/-%d)", $status, $filename, $adds, $dels);

    if (isset($file['previous_filename'])) {
        $line .= " (previously: " . $file['previous_filename'] . ")";
    }

    echo $line . "\n";
}

// Optional: If you want to sort all tags by semantic version, use this:
// $allTags = getAllTags($owner, $repo);
// $sortedTags = sortTagsBySemver($allTags);
// echo "\n--- All tags (semver sorted) ---\n";
// foreach ($sortedTags as $tag) {
//     echo "  " . $tag['name'] . "\n";
// }