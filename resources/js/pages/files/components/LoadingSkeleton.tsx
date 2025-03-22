const LoadingSkeleton = () => {
    return (
        <div role="status" className="w-full animate-pulse cursor-wait">
            <div className="mb-2.5 h-6 rounded-sm bg-gray-200 dark:bg-gray-700"></div>
            <span className="sr-only">Loading...</span>
        </div>
    );
};

export default LoadingSkeleton;

