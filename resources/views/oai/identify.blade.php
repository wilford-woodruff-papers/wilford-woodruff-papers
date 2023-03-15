<?xml version="1.0" encoding="UTF-8"?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
         http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>2002-02-08T12:00:01Z</responseDate>
    <request verb="Identify">http://memory.loc.gov/cgi-bin/oai</request>
    <Identify>
        <repositoryName>Wilford Woodruff Papers Foundation</repositoryName>
        <baseURL>https://wilfordwoodruffpapers.org/oai</baseURL>
        <protocolVersion>2.0</protocolVersion>
        <adminEmail>contact@wilfordwoodruffpapers.org</adminEmail>
        <earliestDatestamp>1990-02-01T12:00:00Z</earliestDatestamp>
        <deletedRecord>transient</deletedRecord>
        <granularity>YYYY-MM-DDThh:mm:ssZ</granularity>
        <compression>deflate</compression>
        <description>
            <oai-identifier
                xmlns="http://www.openarchives.org/OAI/2.0/oai-identifier"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xsi:schemaLocation=
                    "http://www.openarchives.org/OAI/2.0/oai-identifier
                http://www.openarchives.org/OAI/2.0/oai-identifier.xsd">
                <scheme>oai</scheme>
                <repositoryIdentifier>wilfordwoodruffpapers.org</repositoryIdentifier>
                <delimiter>:</delimiter>
                <sampleIdentifier>oai:wilfordwoodruffpapers.org/{{ Str::uuid() }}</sampleIdentifier>
            </oai-identifier>
        </description>
        <description>
            <eprints
                xmlns="http://www.openarchives.org/OAI/1.1/eprints"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xsi:schemaLocation="http://www.openarchives.org/OAI/1.1/eprints
         http://www.openarchives.org/OAI/1.1/eprints.xsd">
                <content>
                    <URL>https://wilfordwoodruffpapers.org</URL>
                    <text>Explore Wilford Woodruff's powerful eyewitness account of the Restoration</text>
                </content>
                <metadataPolicy/>
                <dataPolicy/>
            </eprints>
        </description>
    </Identify>
</OAI-PMH>
