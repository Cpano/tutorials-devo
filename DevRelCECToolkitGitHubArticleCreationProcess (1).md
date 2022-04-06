# CEC Toolkit GitHub Article Creation Process

## Set Up the CEC Toolkit
1. Install the toolkit by changing your current directory to where you wish to install it and run these commands:
	a. ``git clone https://github.com/oracle/content-and-experience-toolkit``
	b. ``cd sites``
	c. ``npm install``
	d. ``sudo ln -s $PWD/node_modules/.bin/cec /usr/local/bin/cec``
2. Create a CEC project to run this process within the directory of your choice using ``cec install``.
3. Create a key to register servers with ``cec create-encryption-key ~/keys/cec.key``.
3. Register whatever servers you need to run this process on with ``cec register-server {SERVER_NAME} -e https://{SITE_PREFIX}.cec.ocp.oraclecloud.com -t dev_osso -u {USERNAME} -p {PASSOWRD} -k ~/keys/cec.key`` For orasites-dev, you can use "osd" as the server name and "orasitesdev-prodapp" as the site prefix.

## Download Content
1. In order to check for existing content, we first need to download it and decide whether it needs to be updated or created.
2. Query for articles and images based on randomly defined IDs: ``cec download-content -r DevO -q '{type eq "DEVO_GitHub-Technical-Content" and fields.github_id eq "l0i8adsr2618825"} or {type eq "ImageAsset" and fields.custom_text_field_1 eq "l0cyti4n76783077"}' -s {SERVER_NAME}``
3. Look through the downloaded files to see if these assets exist. If they don't, go to [Upload New Articles and Images.](#upload-new-articles-and-images) If they do exist, go to [Updating Articles And Images.](#updating-articles-and-images)

## Upload New Articles and Images
1. Create each article, with no content, using the following command and a similar payload: ``cec execute-post "/content/management/api/v1.1/items" -b ./path/uploadPayload.json -s {SERVER_NAME}``
	```
	uploadPayload.json
	{
		"name": "My Article",
		"type": "DEVO_GitHub-Technical-Content",
		"description": "",
		"repositoryId": {DEVO_REPOSITORY_ID},
		"language": "en-US",
		"translatable": true,
		"fields": {
			"html": "DEFINE", // This doesn't need to be defined yet.
			"github_id": "l0cyti4n76783077"
		}
	}
	```
2. Create each image using this command and a similar payload: ``cec create-digital-asset -f ./path/Image.jpg -a ./path/imageFields.json -t ImageAsset -r DevO -s {SERVER_NAME}``
	```
	imageFields.json
	{
		"short_summary": "This is the alt text.",
		"custom_text_field_1": "l0mia9zh78648789"
	}
	```
3. Using the GitHub IDs, download all of the content with: ``cec download-content -r DevO -q '{type eq "DEVO_GitHub-Technical-Content" and fields.github_id eq "l0cyti4n7678307"} or {type eq "ImageAsset" and fields.custom_text_field_1 eq "l0mia9zh78648789"}' -s {SERVER_NAME}``
4. Using this downloaded payload, modify the HTML fields in each corresponding article file as needed. For example, here's an article's abstracted JSON file
	```
	CORE782E55CD07D448C9AB99341755964F54.json
	{
		// Pretend like there's a lot of values up here. Don't change these.
		"fields": {
			"html": "<div>Hello!</div><img src=\"[!--$CEC_DIGITAL_ASSET--]CONT87AB5E67FEE1494F9A349A44527B18B0[/!--$CEC_DIGITAL_ASSET--]\">",
			// Pretend like there's values here. Don't change these.
		}
		// Pretend like there's a lot of values down here. Don't change these.
	}
	```
5. Compress the payload into a zip file and reupload it: ``cec upload-content ./path/payload.zip -f -u -c devo -r DevO -s {SERVER_NAME}``

## Updating Articles And Images
1. Using the downloaded files, modify the HTML fields and image alt texts as needed. For example:
	```
	CORE782E55CD07D448C9AB99341755964F54.json
	{
		// Pretend like there's a lot of values up here. Don't change these.
		"fields": {
			"html": "<div>Hello World! This is different text now.</div><img src=\"[!--$CEC_DIGITAL_ASSET--]CONT87AB5E67FEE1494F9A349A44527B18B0[/!--$CEC_DIGITAL_ASSET--]\">",
			// Pretend like there's values here. Don't change these.
		}
		// Pretend like there's a lot of values down here. Don't change these.
	}
	```
	```
	CONT87AB5E67FEE1494F9A349A44527B18B0.json
	{
		// Pretend like there's a lot of values up here. Don't change these.
		"fields": {
			"short_summary": "This is different alt text now."
			// Pretend like there's values here. Don't change these.
		}
		// Pretend like there's a lot of values down here. Don't change these.
	}
	```
2. Compress the payload into a zip file and reupload it: ``cec upload-content ./path/payload.zip -f -u -c devo -r DevO -s {SERVER_NAME}``

## Publishing Articles And Images
1. After creating or updating new content, hold onto the IDs, and publish content using this command:
	``cec control-content publish -r DevO -q 'id eq "CONTF6D5B162DB6B48CD8CB8B9F28C65F547" or id eq "CONTD2BF07E58F7C4B5DB9DD4DFA2DEDAA6A" id eq "COREA608C5BE37A44D729922154DC0ADB3A0" id eq "CORE5EB8118C120247B7B48E5350C01B3FD2" id eq "COREFBCF8D0B09F744AC9D74EB53D7C691BB"' -c devo -s {SERVER_NAME}``

## Archiving Articles and Images
1. Archive articles and images to make them no longer appear on the base site using this command and a similar payload: ``cec execute-post "/content/management/api/v1.1/bulkItemsOperations/archive" -b ./path/archivePayload.json -s {SERVER_NAME}``
	```
	archivePayload.json
	{
		"q": "id eq \"CORE3AB1F68299824255AFC3A97497479349\" or id eq \"CONT87AB5E67FEE1494F9A349A44527B18B0\""
	}
	```