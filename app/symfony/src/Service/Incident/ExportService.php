<?php

declare(strict_types=1);

namespace App\Service\Incident;

use App\Repository\IncidentRepository;

class ExportService implements ExportInterface
{
    private IncidentRepository $incidentRepository;

    public function __construct(IncidentRepository $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function getExportCsv()
    {
        $handle = fopen('Export incidents.csv', 'w+');

        $tabHeader = [
            'Id',
            'Nom',
            'Prénom',
            'Status',
            'Description',
        ];

        foreach ($tabHeader as $key => $value) {
            $tabHeader[$key] = mb_convert_encoding($value, 'windows-1252', 'utf-8');
        }

        fputcsv($handle, $tabHeader, ';');

        $incidents = $this->incidentRepository->findAll();

        foreach ($incidents as $incident) {
            $tabContent = [
                $incident->getId(),
                $incident->getLastName(),
                $incident->getFirstName(),
                $incident->getStatus(),
                $incident->getDescription(),
            ];

            foreach ($tabContent as $key => $value) {
                $tabContent[$key] = mb_convert_encoding($value, 'windows-1252', 'utf-8');
            }

            fputcsv($handle, $tabContent, ';');
        }

        fclose($handle);

        return $handle;
    }

    public function getExportZip()
    {
        $this->getExportCsv();

        $fileNameCsv = 'Export incidents.csv';

        $archive = new \ZipArchive();
        $zipName = 'export_incidents.zip';
        $archive->open($zipName, \ZipArchive::CREATE);
        $archive->addFile($fileNameCsv);
        $archive->close();

        unlink($fileNameCsv);

        return $zipName;
    }
}
