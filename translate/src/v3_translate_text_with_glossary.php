<?php
/*
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * DO NOT EDIT! This is a generated sample ("Request",  "translate_v3_translate_text_with_glossary")
 */

// sample-metadata
//   title: Translating Text with Glossary
//   description: Translates a given text using a glossary.
//   usage: php v3_translate_text_with_glossary.php [--text "Hello, world!"] [--source_language en] [--target_language fr] [--project_id "[Google Cloud Project ID]"] [--glossary_id "[YOUR_GLOSSARY_ID]"]
// [START translate_v3_translate_text_with_glossary]
require_once __DIR__ . '/../vendor/autoload.php';

use Google\Cloud\Translate\V3\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextGlossaryConfig;

/**
 * Translates a given text using a glossary.
 *
 * @param string $text           The content to translate in string format
 * @param string $sourceLanguage Optional. The BCP-47 language code of the input text.
 * @param string $targetLanguage Required. The BCP-47 language code to use for translation.
 * @param string $glossaryId   Specifies the glossary used for this translation.
 */
function sampleTranslateTextWithGlossary($text, $sourceLanguage, $targetLanguage, $projectId, $glossaryId)
{
    $translationServiceClient = new TranslationServiceClient();

    // $text = 'Hello, world!';
    // $sourceLanguage = 'en';
    // $targetLanguage = 'fr';
    // $projectId = '[Google Cloud Project ID]';
    // $glossaryId = '[YOUR_GLOSSARY_ID]';
    $glossaryPath = $translationServiceClient->glossaryName($projectId, 'us-central1', $glossaryId);
    $contents = [$text];
    $formattedParent = $translationServiceClient->locationName($projectId, 'us-central1');
    $glossaryConfig = new TranslateTextGlossaryConfig();
    $glossaryConfig->setGlossary($glossaryPath);

    // Optional. Can be "text/plain" or "text/html".
    $mimeType = 'text/plain';

    try {
        print($formattedParent);
        $response = $translationServiceClient->translateText($contents, $targetLanguage, $formattedParent, ['sourceLanguageCode' => $sourceLanguage, 'glossaryConfig' => $glossaryConfig, 'mimeType' => $mimeType]);
        // Display the translation for each input text provided
        foreach ($response->getGlossaryTranslations() as $translation) {
            printf('Translated text: %s' . PHP_EOL, $translation->getTranslatedText());
        }
    } finally {
        $translationServiceClient->close();
    }
}
// [END translate_v3_translate_text_with_glossary]

$opts = [
    'text::',
    'source_language::',
    'target_language::',
    'project_id::',
    'glossary_id::',
];

$defaultOptions = [
    'text' => 'Hello, world!',
    'source_language' => 'en',
    'target_language' => 'fr',
    'project_id' => '[Google Cloud Project ID]',
    'glossary_id' => 'projects/[YOUR_PROJECT_ID]/locations/[LOCATION]/glossaries/[YOUR_GLOSSARY_ID]',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$text = $options['text'];
$sourceLanguage = $options['source_language'];
$targetLanguage = $options['target_language'];
$projectId = $options['project_id'];
$glossaryId = $options['glossary_id'];

sampleTranslateTextWithGlossary($text, $sourceLanguage, $targetLanguage, $projectId, $glossaryId);
