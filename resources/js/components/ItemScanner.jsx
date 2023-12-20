import React, { useEffect, useRef } from 'react'


async function streamVideo(videoEl) {
    const stream = await navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: { ideal: 'environment' }
        },
        audio: false
    });

    videoEl.srcObject = stream;
    await videoEl.play();

    return stream;
}

function destroyVideo(stream) {
    const tracks = stream.getTracks();

    tracks.forEach(function (track) {
        track.stop();
    });
}

async function detectBarcode(videoEl, setScannedBarcode, stream) {
    if ('BarcodeDetector' in window) {
        console.log('Barcode Detector supported!');
    } else {
        alert('Barcode Detector is not supported in this browser');
    }
    const barcodeDetector = new BarcodeDetector();

    const interval = setInterval(async () => {
        const barcodes = await barcodeDetector.detect(videoEl);
        if (barcodes.length > 0) {
            clearInterval(interval);
            destroyVideo(stream);
            setScannedBarcode(barcodes[0].rawValue);
        }
    }, 1000);

    return interval;
}

export default function ItemScanner({ scannedBarcode, setScannedBarcode }) {
    const videoRef = useRef(null);

    useEffect(() => {
        if (scannedBarcode) return;

        let interval;
        let stream;

        streamVideo(videoRef.current).then((st) => {
            stream = st;
            interval = detectBarcode(videoRef.current, setScannedBarcode, stream);
        });

        return () => {
            clearInterval(interval);
            destroyVideo(stream);
        }
    }, [scannedBarcode])


    return (
        <div>
            <video className="video-stream" ref={videoRef} />
        </div>
    )
}
