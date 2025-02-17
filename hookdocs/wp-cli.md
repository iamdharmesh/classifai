The following WP-CLI commands are supported by ClassifAI:

### Language Processing Commands

* `wp classifai post <post_ids> [--post_type=<post_type>] [--limit=<limit>] [--link=<link>]`

  Batch post classification using IBM Watson NLU API.

  * `<post_ids>`: A comma delimited list of post IDs to classify. Used if post_type is false or absent.

    default: `true`

  * `[--post_type=<post_type>]`: Batch classify posts belonging to this post type. If false or absent relies on post_ids.

    default: `false`

    options:

    - any post type name
    - `false`, if args contains post_ids

  * `[--limit=<limit>]`: Limit classification to N posts.

    default: `false`

    options:

    - `false`, no limit
    - N, max number of posts to classify

  * `[--link=<link>]`: Whether to link classification results to Taxonomy terms.

    default: `true`

* `wp classifai text <text> [--category=<bool>] [--keyword=<bool>] [--concept=<bool>] [--entity=<bool>] [--input=<input>] [--only-normalize=<bool>]`

  Directly classify text using IBM Watson NLU API.

  * `<text>`: A string of text to classify.

  * `[--category=<bool>]`: Enables NLU category feature.

    default: `true`

  * `[--keyword=<bool>]`: Enables NLU keyword feature.

    default: `true`

  * `[--concept=<bool>]`: Enables NLU concept feature.

    default: `true`

  * `[--entity=<bool>]`: Enables NLU entity feature.

    default: `true`

  * `[--input=<input>]`: Path to input file or URL.

    default: `false`

    options:

    - path to local file
    - path to remote URL
    - `false`, uses `args[0]` instead

  * `[--only-normalize=<bool>]`: Prints the normalized text that will be sent to the NLU API.

    default: `false`

* `wp classifai text_to_speech <post_ids> [--post_type=<post_type>] [--post_status=<post_status>] [--per_page=<per_page>] [--dry-run=<bool>]`

  Batch generation of text-to-speech data using Microsoft Azure's Text to Speech API.

  * `<post_ids>`: A comma-delimited list of post IDs to generate text-to-speech for. Used if post_type is `false` or absent.

    default: `null`

  * `[--post_type=<post_type>]`: Batch process items belonging to this post type. If `false` or absent, will rely on `post_ids`.

    default: `false`

    options:

    * any post type name

  * `[--post_status=<post_status>]`: Batch process items that have this post status. Defaults to `publish`.

    default: `publish`

    options:

    * any post status name

  * `[--per_page=<int>]`: How many items should be processed at a time. Will still process all items but will do it in batches matching this number. Defaults to 100.

    default: `100`

    options:

    * N, max number of items to process at a time

  * `[--dry-run=<bool>]`: Whether to run as a dry-run. Defaults to `true`, so will run in dry-run mode unless this is set to `false`.

    default: `true`

    options:

    * `true` to run in dry-run mode
    * `false` to run in normal mode

* `wp classifai transcribe_audio <attachment_ids> [--per_page=<per_page>] [--force=<bool>] [--dry-run=<bool>]`

  Batch generation of audio transcriptions using OpenAI's Whisper API.

  * `<attachment_ids>`: A comma-delimited list of attachment IDs to generate transcriptions for. If not set, will instead run a query to get all audio attachments to process.

    default: `null`

  * `[--per_page=<int>]`: How many items should be processed at a time. Will still process all items but will do it in batches matching this number. Defaults to 100.

    default: `100`

    options:

    * N, max number of items to process at a time

  * `[--force=<bool>]`: Whether to process audio files that already have a transcription set. Defaults to `false`.

    default: `false`

    options:

    * `true` to process all items
    * `false` to only process items that don't have transcriptions set

  * `[--dry-run=<bool>]`: Whether to run as a dry-run. Defaults to `true`, so will run in dry-run mode unless this is set to `false`.

    default: `true`

    options:

    * `true` to run in dry-run mode
    * `false` to run in normal mode

* `wp classifai generate_excerpt <post_ids> [--post_type=<post_type>] [--post_status=<post_status>] [--per_page=<per_page>] [--force=<bool>] [--dry-run=<bool>]`

  Batch generation of excerpts using OpenAI's ChatGPT API.

  * `<post_ids>`: A comma-delimited list of post IDs to generate excerpts for. Used if post_type is `false` or absent.

    default: `null`

  * `[--post_type=<post_type>]`: Batch process items belonging to this post type. If `false` or absent, will rely on `post_ids`.

    default: `false`

    options:

    * any post type name

  * `[--post_status=<post_status>]`: Batch process items that have this post status. Defaults to `publish`.

    default: `publish`

    options:

    * any post status name

  * `[--per_page=<int>]`: How many items should be processed at a time. Will still process all items but will do it in batches matching this number. Defaults to 100.

    default: `100`

    options:

    * N, max number of items to process at a time

  * `[--force=<bool>]`: Whether to process items that already have an excerpt set. Defaults to `false`.

    default: `false`

    options:

    * `true` to process all items
    * `false` to only process items that don't have an excerpt set

  * `[--dry-run=<bool>]`: Whether to run as a dry-run. Defaults to `true`, so will run in dry-run mode unless this is set to `false`.

    default: `true`

    options:

    * `true` to run in dry-run mode
    * `false` to run in normal mode

* `wp classifai embeddings <post_ids> [--post_type=<post_type>] [--post_status=<post_status>] [--per_page=<per_page>] [--dry-run=<bool>]`

  Batch classification of items using the OpenAI Embeddings API.

  * `<post_ids>`: A comma-delimited list of post IDs to classify. Used if `post_type` is `false` or absent.

    default: `null`

  * `[--post_type=<post_type>]`: Batch process items belonging to this post type. If `false` or absent, will rely on `post_ids`.

    default: `false`

    options:

    * any post type name

  * `[--post_status=<post_status>]`: Batch process items that have this post status. Defaults to `publish`.

    default: `publish`

    options:

    * any post status name

  * `[--per_page=<int>]`: How many items should be processed at a time. Will still process all items but will do it in batches matching this number. Defaults to 100.

    default: `100`

    options:

    * N, max number of items to process at a time

  * `[--dry-run=<bool>]`: Whether to run as a dry-run. Defaults to `true`, so will run in dry-run mode unless this is set to `false`.

    default: `true`

    options:

    * `true` to run in dry-run mode
    * `false` to run in normal mode

### Image Processing Commands

* `wp classifai image <attachment_ids> [--limit=<int>] [--skip=<skip>] [--force]`

  Directly add description "alt text" and tags to attachment(s) using Azure AI Computer Vision API.

  * `<attachment_ids>`: Comma delimited list of Attachment IDs to classify.

  * `[--limit=<int>]`: Limit number of attachments to classify.

    default: `100`

  * `[--skip=<skip>]`: Skip first N attachments.

    default: `false`

  * `[--force]`: Force classifying attachments regardless of their alt.

    default: `false`

* `wp classifai crop <attachment_ids> [--limit=<limit>] [--skip=<skip>]`

  Batch crop image(s) using Azure AI Computer Vision API.

  * `<attachment_ids>`: Comma delimited list of Attachment IDs to crop.

  * `[--limit=<int>]`: Limit number of attachments to crop.

	default: `100`

  * `[--skip=<skip>]`: Skip first N attachments.

	default: `false`

### ClassifAI Settings Commands

* `wp classifai auth`

  Prints the Basic Auth header based on credentials configured in the plugin.

* `wp classifai reset`

  Restores the plugin configuration to factory defaults. Any API credentials will need to be re-entered after this is ran.
