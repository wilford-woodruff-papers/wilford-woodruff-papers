
<?xml version="1.0" encoding="UTF-8"?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
         http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{{ now()->toIso8601ZuluString() }}</responseDate>
    <request verb="GetRecord" identifier="{{ $identifier }}"
             metadataPrefix="oai_dc">{{ route('oai') }}</request>
    <error code="idDoesNotExist">No matching identifier in the Wilford Woodruff Papers</error>
</OAI-PMH>
