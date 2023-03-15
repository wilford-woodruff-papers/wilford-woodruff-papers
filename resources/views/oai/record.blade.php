<?xml version="1.0" encoding="UTF-8"?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
         http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{{ now()->toIso8601ZuluString() }}</responseDate>
    <request verb="GetRecord" identifier="oai:arXiv.org:cs/0112017"
             metadataPrefix="oai_dc">http://arXiv.org/oai2</request>
    <GetRecord>
        <record>
            <header>
                <identifier>oai:{{ $item->uuid }}</identifier>
                <datestamp>{{ $item->updated_at->toDateString() }}</datestamp>
                <setSpec>{{ $item->type?->name }}</setSpec>
            </header>
            <metadata>
                <oai_dc:dc
                    xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/"
                    xmlns:dc="http://purl.org/dc/elements/1.1/"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/
         http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
                    <dc:title>{{ $item->publiC_name }}</dc:title>
                    <dc:creator>Wilford Woodruff</dc:creator>
                    <dc:subject></dc:subject>
                    <dc:description></dc:description>
                    <dc:date>{{ $item->sort_date?->toDateString() }}</dc:date>
                </oai_dc:dc>
            </metadata>
        </record>
    </GetRecord>
</OAI-PMH>
