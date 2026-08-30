const PageShell = ({ children }) => (
  <div className="min-h-screen bg-[#12060c]">
    <div className="page-transition mx-auto flex min-h-screen w-full items-stretch justify-center">
      {children}
    </div>
  </div>
);

export default PageShell;
